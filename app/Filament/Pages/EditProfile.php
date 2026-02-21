<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Select::make('locale')
                            ->label('Admin language')
                            ->options([
                                'da' => '🇩🇰 Dansk',
                                'en' => '🇬🇧 English',
                            ])
                            ->default('da')
                            ->required()
                            ->helperText('Language used for the admin panel interface.'),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
            ),
        ];
    }
}
