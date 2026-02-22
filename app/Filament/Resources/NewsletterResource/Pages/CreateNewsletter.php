<?php

namespace App\Filament\Resources\NewsletterResource\Pages;

use App\Filament\Resources\NewsletterResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletter extends CreateRecord
{
    protected static string $resource = NewsletterResource::class;

    // Tracks whether preview should open after save
    public bool $previewAfterSave = false;

    // Redirect to edit page after creation so Preview + Send are immediately available
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getFormActions(): array
    {
        return [
            // "Save Draft" — default create button
            $this->getCreateFormAction()
                ->label(__('admin.newsletter.save_draft')),

            // "Save Draft & Preview" — saves then opens preview in new tab
            Action::make('saveAndPreview')
                ->label(__('admin.newsletter.save_and_preview'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->action(function () {
                    $this->previewAfterSave = true;
                    $this->create();
                }),

            $this->getCancelFormAction(),
        ];
    }

    protected function afterCreate(): void
    {
        if ($this->previewAfterSave) {
            $previewUrl = route('newsletters.preview', $this->getRecord());
            $this->js("window.open('" . $previewUrl . "', '_blank')");
        }
    }
}
