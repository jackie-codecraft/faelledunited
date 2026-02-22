<?php

namespace App\Filament\Resources\NewsletterResource\Pages;

use App\Filament\Resources\NewsletterResource;
use App\Jobs\SendNewsletter;
use App\Models\NewsletterSubscriber;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditNewsletter extends EditRecord
{
    protected static string $resource = NewsletterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label(__('admin.newsletter.preview'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('newsletters.preview', $this->record))
                ->openUrlInNewTab(),

            Actions\Action::make('send')
                ->label(__('admin.newsletter.send'))
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->visible(fn () => $this->record->status === 'draft')
                ->requiresConfirmation()
                ->modalHeading(__('admin.newsletter.send_confirm_heading'))
                ->modalDescription(function () {
                    $count = $this->record->recipient_type === 'all'
                        ? NewsletterSubscriber::where('confirmed', true)->count()
                        : count($this->record->recipient_ids ?? []);
                    return __('admin.newsletter.send_confirm', ['count' => $count]);
                })
                ->modalSubmitActionLabel(__('admin.newsletter.send'))
                ->action(function () {
                    SendNewsletter::dispatch($this->record);
                    Notification::make()
                        ->title(__('admin.newsletter.send_success'))
                        ->success()
                        ->send();
                    $this->redirect(NewsletterResource::getUrl('index'));
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
