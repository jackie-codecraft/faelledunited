<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Mail\UserInvitation;
use App\Models\BoardMember;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 100;

    public static function getNavigationGroup(): ?string  { return __('admin.nav_group.administration'); }
    public static function getNavigationLabel(): string   { return __('admin.nav.users'); }
    public static function getModelLabel(): string        { return __('admin.model.user'); }
    public static function getPluralModelLabel(): string  { return __('admin.model.users'); }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('admin.section.account'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.col.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label(__('admin.col.email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(User::class, 'email', ignoreRecord: true),

                        Forms\Components\Select::make('locale')
                            ->label(__('admin.col.language'))
                            ->options([
                                'da' => '🇩🇰 Dansk',
                                'en' => '🇬🇧 English',
                            ])
                            ->default('da')
                            ->required(),
                    ])->columns(2),

                // ── Invite toggle (create only) ──────────────────────────
                Forms\Components\Section::make(__('admin.section.invite'))
                    ->description(__('admin.section.invite_desc'))
                    ->schema([
                        Forms\Components\Toggle::make('send_invite')
                            ->label(__('admin.col.send_invite'))
                            ->default(true)
                            ->live()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateUser),

                // ── Password (optional on create when invite is on) ──────
                Forms\Components\Section::make(__('admin.section.password'))
                    ->description(fn ($livewire) => $livewire instanceof Pages\EditUser
                        ? __('admin.section.password_edit_hint')
                        : null)
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label(__('admin.col.password'))
                            ->password()
                            ->revealable()
                            ->rule(Password::defaults())
                            ->required(fn (Get $get, $livewire) =>
                                $livewire instanceof Pages\CreateUser && ! $get('send_invite')
                            )
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->columnSpanFull()
                            ->helperText(fn (Get $get, $livewire) =>
                                $livewire instanceof Pages\CreateUser && $get('send_invite')
                                    ? __('admin.invite.password_skipped')
                                    : null
                            ),
                    ])
                    ->visible(fn (Get $get, $livewire) =>
                        $livewire instanceof Pages\EditUser || ! $get('send_invite')
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.col.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.col.email'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('locale')
                    ->label(__('admin.col.language'))
                    ->formatStateUsing(fn ($state) => $state === 'en' ? '🇬🇧 English' : '🇩🇰 Dansk')
                    ->color('success'),

                // Invite status badge
                Tables\Columns\BadgeColumn::make('invite_status')
                    ->label(__('admin.col.invite_status'))
                    ->getStateUsing(fn (User $record) => $record->inviteStatus())
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'active'  => __('admin.invite.status_active'),
                        'pending' => __('admin.invite.status_pending'),
                        default   => __('admin.invite.status_none'),
                    })
                    ->color(fn (string $state) => match ($state) {
                        'active'  => 'success',
                        'pending' => 'warning',
                        default   => 'gray',
                    })
                    ->icon(fn (string $state) => match ($state) {
                        'active'  => 'heroicon-o-check-circle',
                        'pending' => 'heroicon-o-clock',
                        default   => 'heroicon-o-envelope',
                    }),

                Tables\Columns\IconColumn::make('boardMember.id')
                    ->label(__('admin.col.board_member'))
                    ->boolean()
                    ->trueIcon('heroicon-o-identification')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn ($record) => $record->boardMember?->role_da),

                Tables\Columns\TextColumn::make('invite_sent_at')
                    ->label(__('admin.col.invite_sent'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.col.created'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('invite')
                    ->label(fn (User $record) => $record->invite_sent_at
                        ? __('admin.invite.resend')
                        : __('admin.invite.send')
                    )
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->visible(fn (User $record) => $record->invite_accepted_at === null)
                    ->requiresConfirmation()
                    ->modalHeading(fn (User $record) => $record->invite_sent_at
                        ? __('admin.invite.resend')
                        : __('admin.invite.send')
                    )
                    ->modalDescription(fn (User $record) => __('admin.invite.confirm_desc', [
                        'email' => $record->email,
                    ]))
                    ->action(function (User $record) {
                        static::sendInvite($record);
                    }),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->disabled(fn (User $record) => $record->id === auth()->id())
                    ->tooltip(fn (User $record) => $record->id === auth()->id()
                        ? __('admin.users.cannot_delete_self')
                        : null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            if ($records->contains('id', auth()->id())) {
                                Notification::make()
                                    ->title(__('admin.users.cannot_delete_self'))
                                    ->danger()
                                    ->send();
                                $records->forget(
                                    $records->search(fn ($r) => $r->id === auth()->id())
                                );
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    /** Generate invite token and dispatch email. */
    public static function sendInvite(User $user): void
    {
        $user->generateInviteToken();

        try {
            Mail::to($user->email)->send(new UserInvitation($user));

            Notification::make()
                ->title(__('admin.invite.sent_success', ['email' => $user->email]))
                ->success()
                ->send();
        } catch (\Throwable $e) {
            report($e);
            Notification::make()
                ->title(__('admin.invite.sent_error'))
                ->danger()
                ->send();
        }
    }
}
