<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInquiryResource\Pages;
use App\Mail\ContactInquiryReply;
use App\Models\ContactInquiry;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\HtmlString;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class ContactInquiryResource extends Resource
{
    protected static ?string $model = ContactInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?int    $navigationSort = 1;

    public static function getNavigationGroup(): ?string   { return __('admin.nav_group.communications'); }
    public static function getNavigationLabel(): string    { return __('admin.nav.contact_inquiries'); }
    public static function getModelLabel(): string         { return __('admin.model.inquiry'); }
    public static function getPluralModelLabel(): string   { return __('admin.model.contact_inquiries'); }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'new'         => __('admin.inquiry.status.new'),
                        'in_progress' => __('admin.inquiry.status.in_progress'),
                        'resolved'    => __('admin.inquiry.status.resolved'),
                        'replied'     => __('admin.inquiry.status.replied'),
                    ])
                    ->required(),
                Forms\Components\Select::make('assigned_to')
                    ->label(__('admin.col.assigned_to'))
                    ->options(fn () => User::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('— ' . __('admin.col.unassigned') . ' —')
                    ->nullable(),
                Forms\Components\Textarea::make('internal_notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'         => 'warning',
                        'in_progress' => 'primary',
                        'resolved'    => 'success',
                        'replied'     => 'success',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __('admin.inquiry.status.' . $state)),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label(__('admin.col.assigned_to'))
                    ->default('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => __('admin.inquiry.status.new'),
                        'in_progress' => __('admin.inquiry.status.in_progress'),
                        'resolved'    => __('admin.inquiry.status.resolved'),
                        'replied'     => __('admin.inquiry.status.replied'),
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label(__('admin.inquiry.action.reply'))
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->form([
                        Forms\Components\Placeholder::make('inquiry_details')
                            ->label(__('admin.inquiry.original_message_label'))
                            ->content(fn (ContactInquiry $record): HtmlString => new HtmlString(
                                '<div class="rounded-lg border border-gray-200 bg-gray-50 p-4 space-y-2 text-sm">'
                                . '<div class="grid grid-cols-[5rem_1fr] gap-x-3 gap-y-1.5">'
                                . '<span class="text-gray-500 font-medium">' . __('admin.inquiry.field.from') . '</span>'
                                . '<span class="font-semibold text-gray-800">' . e($record->name) . ' &lt;' . e($record->email) . '&gt;</span>'
                                . '<span class="text-gray-500 font-medium">' . __('admin.inquiry.field.subject') . '</span>'
                                . '<span class="font-semibold text-gray-800">' . e($record->subject ?? '—') . '</span>'
                                . '<span class="text-gray-500 font-medium">' . __('admin.inquiry.field.received') . '</span>'
                                . '<span class="text-gray-600">' . e($record->created_at->format('d. M Y \k\l. H:i')) . '</span>'
                                . '</div>'
                                . '<div class="border-t border-gray-200 pt-3 mt-1">'
                                . '<p class="text-gray-500 mb-1">' . __('admin.inquiry.field.message') . '</p>'
                                . '<p class="text-gray-800 leading-relaxed whitespace-pre-wrap">' . e($record->message) . '</p>'
                                . '</div>'
                                . '</div>'
                            )),
                        Forms\Components\Textarea::make('reply_message')
                            ->label(__('admin.inquiry.reply_message'))
                            ->required()
                            ->rows(6),
                    ])
                    ->action(function (ContactInquiry $record, array $data): void {
                        Mail::to($record->email)->send(
                            new ContactInquiryReply($record, $data['reply_message'])
                        );

                        $record->status = 'replied';
                        $record->save();

                        Notification::make()
                            ->title(__('admin.inquiry.reply_sent'))
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListContactInquiries::route('/'),
            'create' => Pages\CreateContactInquiry::route('/create'),
            'edit'   => Pages\EditContactInquiry::route('/{record}/edit'),
        ];
    }
}
