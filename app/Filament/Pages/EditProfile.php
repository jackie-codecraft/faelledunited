<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    /**
     * Render inside the full panel layout (sidebar + nav) instead
     * of the detached standalone simple layout.
     */
    public static function isSimple(): bool
    {
        return false;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make(__('admin.section.account'))
                            ->schema([
                                $this->getNameFormComponent(),
                                $this->getEmailFormComponent(),
                                Select::make('locale')
                                    ->label(__('admin.col.language'))
                                    ->options([
                                        'da' => '🇩🇰 Dansk',
                                        'en' => '🇬🇧 English',
                                    ])
                                    ->default('da')
                                    ->required()
                                    ->helperText(__('admin.profile.language_hint'))
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Section::make(__('admin.section.password'))
                            ->description(__('admin.section.password_edit_hint'))
                            ->schema([
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                            ])
                            ->columns(2),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
            ),
        ];
    }
}
