<?php

namespace App\Filament\Widgets;

use App\Mail\ContactInquiryReply;
use App\Models\ContactInquiry;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class OpenInquiriesWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('admin.dashboard.open_inquiries'))
            ->query(
                ContactInquiry::query()
                    ->where('status', 'new')
                    ->orderByDesc('created_at')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.col.name'))
                    ->searchable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('subject')
                    ->label(__('admin.col.subject'))
                    ->limit(50)
                    ->tooltip(fn (ContactInquiry $record): string => $record->subject ?? '')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.col.submitted'))
                    ->since()
                    ->sortable(),
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

                Tables\Actions\Action::make('edit')
                    ->label(__('admin.action.view'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (ContactInquiry $record): string => route(
                        'filament.admin.resources.contact-inquiries.edit',
                        ['record' => $record]
                    )),
            ])
            ->headerActions([
                Tables\Actions\Action::make('view_all_inquiries')
                    ->label(__('admin.dashboard.view_all'))
                    ->url(route('filament.admin.resources.contact-inquiries.index'))
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->size('sm'),
            ])
            ->paginated(false)
            ->emptyStateIcon('heroicon-o-check-circle')
            ->emptyStateHeading(__('admin.dashboard.all_clear_inquiries'))
            ->emptyStateDescription(__('admin.dashboard.empty_desc.all_caught_up'));
    }
}
