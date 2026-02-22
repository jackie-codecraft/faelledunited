<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('invite')
                ->label(fn () => $this->record->invite_sent_at
                    ? __('admin.invite.resend')
                    : __('admin.invite.send')
                )
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->visible(fn () => $this->record->invite_accepted_at === null)
                ->requiresConfirmation()
                ->modalDescription(fn () => __('admin.invite.confirm_desc', [
                    'email' => $this->record->email,
                ]))
                ->action(fn () => UserResource::sendInvite($this->record)),

            Actions\DeleteAction::make()
                ->disabled(fn () => $this->record->id === auth()->id()),
        ];
    }
}
