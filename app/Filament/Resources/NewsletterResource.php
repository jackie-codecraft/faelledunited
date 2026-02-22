<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterResource\Pages;
use App\Jobs\SendNewsletter;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\HtmlString;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterResource extends Resource
{
    protected static ?string $model = Newsletter::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';
    protected static ?int    $navigationSort = 3;

    public static function getNavigationGroup(): ?string   { return __('admin.nav_group.communications'); }
    public static function getNavigationLabel(): string    { return __('admin.nav.newsletter'); }
    public static function getModelLabel(): string         { return __('admin.model.newsletter'); }
    public static function getPluralModelLabel(): string   { return __('admin.model.newsletters'); }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return $record->status === 'draft';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('draft_notice')
                    ->label('')
                    ->content(fn (): HtmlString => new HtmlString(
                        '<div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 flex gap-3 text-sm text-blue-800">'
                        . '<svg class="h-5 w-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        . '<div>'
                        . '<p class="font-semibold">' . __('admin.newsletter.draft_notice_title') . '</p>'
                        . '<p class="mt-0.5 text-blue-700">' . __('admin.newsletter.draft_notice_body') . '</p>'
                        . '</div>'
                        . '</div>'
                    ))
                    ->visibleOn('create')
                    ->columnSpanFull(),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->label(__('admin.col.subject'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body')
                            ->label(__('admin.col.body'))
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('newsletters')
                            ->columnSpanFull(),

                        Forms\Components\Radio::make('recipient_type')
                            ->label(__('admin.col.recipient_type'))
                            ->options([
                                'all'    => __('admin.newsletter.recipient_type_all'),
                                'custom' => __('admin.newsletter.recipient_type_custom'),
                            ])
                            ->default('all')
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('recipient_ids')
                            ->label(__('admin.col.recipients'))
                            ->multiple()
                            ->searchable()
                            ->options(
                                NewsletterSubscriber::where('confirmed', true)
                                    ->pluck('email', 'id')
                                    ->toArray()
                            )
                            ->visible(fn (Get $get) => $get('recipient_type') === 'custom')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('admin.col.subject'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('recipient_type')
                    ->label(__('admin.col.recipient_type'))
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'all'    => 'info',
                        'custom' => 'primary',
                        default  => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'all'    => __('admin.newsletter.recipient_type_all'),
                        'custom' => __('admin.newsletter.recipient_type_custom'),
                        default  => $state,
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin.col.status'))
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft'   => 'gray',
                        'sending' => 'warning',
                        'sent'    => 'success',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'draft'   => __('admin.newsletter.status_draft'),
                        'sending' => __('admin.newsletter.status_sending'),
                        'sent'    => __('admin.newsletter.status_sent'),
                        default   => $state,
                    }),

                Tables\Columns\TextColumn::make('total_sent')
                    ->label(__('admin.newsletter.total_sent'))
                    ->sortable()
                    ->placeholder('—')
                    ->formatStateUsing(fn ($state, $record) => $record->status === 'sent' ? $state : '—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('sent_at')
                    ->label(__('admin.newsletter.sent_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.col.created'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn (Newsletter $record) => $record->status !== 'draft'),
                Tables\Actions\ViewAction::make()
                    ->hidden(fn (Newsletter $record) => $record->status === 'draft'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->hidden(fn () => false),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNewsletters::route('/'),
            'create' => Pages\CreateNewsletter::route('/create'),
            'edit'   => Pages\EditNewsletter::route('/{record}/edit'),
            'view'   => Pages\ViewNewsletter::route('/{record}'),
        ];
    }
}
