<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Database\Eloquent\Model;

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

    /** Temporarily holds board member fields extracted before the user save. */
    private ?array $pendingBoardMemberData = null;

    // ── Form ─────────────────────────────────────────────────────────────────

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

                        // Only shown for users linked to a board member record
                        Section::make(__('admin.section.board_profile'))
                            ->description(__('admin.section.board_profile_hint'))
                            ->statePath('board_profile')
                            ->schema([
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

    // ── Hooks ────────────────────────────────────────────────────────────────

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $boardMember = $this->getUser()->boardMember;

        if ($boardMember) {
            $data['board_profile'] = [
                'photo' => $boardMember->photo,
            ];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['board_profile'])) {
            $this->pendingBoardMemberData = $data['board_profile'];
            unset($data['board_profile']);
        }

        return $data;
    }

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
