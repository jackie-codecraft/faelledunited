<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /** If "Send invite" is on, set a random unusable password before saving. */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // send_invite is non-dehydrated — read from raw form state
        $sendInvite = $this->form->getRawState()['send_invite'] ?? false;

        if ($sendInvite) {
            $data['password'] = Hash::make(Str::random(32));
        }
        return $data;
    }

    /** After the record is saved, send the invite email if requested. */
    protected function afterCreate(): void
    {
        $sendInvite = $this->form->getRawState()['send_invite'] ?? false;

        if ($sendInvite) {
            UserResource::sendInvite($this->record);
        }
    }
}
