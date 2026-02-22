<?php

namespace App\Filament\Resources\ContactInquiryResource\Pages;

use App\Filament\Resources\ContactInquiryResource;
use App\Mail\ContactInquiryReply;
use App\Models\ContactInquiry;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class EditContactInquiry extends EditRecord
{
    protected static string $resource = ContactInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply')
                ->label(__('admin.inquiry.action.reply'))
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->form([
                    Forms\Components\Placeholder::make('inquiry_details')
                        ->label(__('admin.inquiry.original_message_label'))
                        ->content(fn (): HtmlString => new HtmlString(
                            '<div class="rounded-lg border border-gray-200 bg-gray-50 p-4 space-y-2 text-sm">'
                            . '<div class="grid grid-cols-[5rem_1fr] gap-x-3 gap-y-1.5">'
                            . '<span class="text-gray-500 font-medium">' . __('admin.inquiry.field.from') . '</span>'
                            . '<span class="font-semibold text-gray-800">' . e($this->record->name) . ' &lt;' . e($this->record->email) . '&gt;</span>'
                            . '<span class="text-gray-500 font-medium">' . __('admin.inquiry.field.subject') . '</span>'
                            . '<span class="font-semibold text-gray-800">' . e($this->record->subject ?? '—') . '</span>'
                            . '<span class="text-gray-500 font-medium">' . __('admin.inquiry.field.received') . '</span>'
                            . '<span class="text-gray-600">' . e($this->record->created_at->format('d. M Y \k\l. H:i')) . '</span>'
                            . '</div>'
                            . '<div class="border-t border-gray-200 pt-3 mt-1">'
                            . '<p class="text-gray-500 mb-1">' . __('admin.inquiry.field.message') . '</p>'
                            . '<p class="text-gray-800 leading-relaxed whitespace-pre-wrap">' . e($this->record->message) . '</p>'
                            . '</div>'
                            . '</div>'
                        )),
                    Forms\Components\Textarea::make('reply_message')
                        ->label(__('admin.inquiry.reply_message'))
                        ->required()
                        ->rows(6),
                ])
                ->action(function (array $data): void {
                    Mail::to($this->record->email)->send(
                        new ContactInquiryReply($this->record, $data['reply_message'])
                    );

                    $this->record->status = 'replied';
                    $this->record->save();

                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title(__('admin.inquiry.reply_sent'))
                        ->success()
                        ->send();
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
