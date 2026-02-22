<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Database\Eloquent\Model;

class EditProfile extends BaseEditProfile
{
    /** Temporarily holds board member fields extracted before the user save. */
    private ?array $pendingBoardMemberData = null;

    // ── Form definition ──────────────────────────────────────────────────────

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        // ── Account settings ──────────────────────────────
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

                        // ── Password ──────────────────────────────────────
                        Section::make(__('admin.section.password'))
                            ->description(__('admin.section.password_edit_hint'))
                            ->schema([
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                            ])
                            ->columns(2),

                        // ── Board member profile (only if linked) ─────────
                        Section::make(__('admin.section.board_profile'))
                            ->description(__('admin.section.board_profile_hint'))
                            ->statePath('board_profile')
                            ->schema([
                                Tabs::make('board_profile_tabs')
                                    ->tabs([
                                        Tab::make('🇩🇰 Dansk')
                                            ->schema([
                                                TextInput::make('role_da')
                                                    ->label(__('admin.col.role_da'))
                                                    ->maxLength(255),
                                                Textarea::make('bio_da')
                                                    ->label(__('admin.col.bio_da'))
                                                    ->rows(4)
                                                    ->columnSpanFull(),
                                            ]),
                                        Tab::make('🇬🇧 English')
                                            ->schema([
                                                TextInput::make('role_en')
                                                    ->label(__('admin.col.role_en'))
                                                    ->maxLength(255),
                                                Textarea::make('bio_en')
                                                    ->label(__('admin.col.bio_en'))
                                                    ->rows(4)
                                                    ->columnSpanFull(),
                                            ]),
                                    ])
                                    ->columnSpanFull(),

                                FileUpload::make('photo')
                                    ->label(__('admin.col.photo'))
                                    ->helperText(__('admin.col.photo_hint'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('board-members')
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->imageEditorAspectRatios(['1:1'])
                                    ->maxSize(4096)
                                    ->columnSpanFull(),
                            ])
                            ->visible(fn () => $this->getUser()->boardMember !== null),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
            ),
        ];
    }

    // ── Data hooks ───────────────────────────────────────────────────────────

    /**
     * Populate board member fields into form data before rendering.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $boardMember = $this->getUser()->boardMember;

        if ($boardMember) {
            $data['board_profile'] = [
                'role_da' => $boardMember->role_da,
                'role_en' => $boardMember->role_en,
                'bio_da'  => $boardMember->bio_da,
                'bio_en'  => $boardMember->bio_en,
                'photo'   => $boardMember->photo,
            ];
        }

        return $data;
    }

    /**
     * Extract board member fields before the user record is saved.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['board_profile'])) {
            $this->pendingBoardMemberData = $data['board_profile'];
            unset($data['board_profile']);
        }

        return $data;
    }

    /**
     * Save user record, then flush any pending board member data.
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        parent::handleRecordUpdate($record, $data);

        if ($this->pendingBoardMemberData !== null) {
            $record->load('boardMember');

            if ($record->boardMember) {
                $record->boardMember->update($this->pendingBoardMemberData);
            }

            $this->pendingBoardMemberData = null;
        }

        return $record;
    }
}
