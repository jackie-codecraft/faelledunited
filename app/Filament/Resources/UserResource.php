<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string  { return __('admin.nav_group.settings'); }
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
                            ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->columnSpanFull(),
                    ]),
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

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.col.created'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
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
                            // Prevent deleting yourself in a bulk action
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
}
