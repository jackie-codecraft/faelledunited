<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardMemberResource\Pages;
use App\Filament\Resources\BoardMemberResource\RelationManagers;
use App\Models\BoardMember;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoardMemberResource extends Resource
{
    protected static ?string $model = BoardMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?int    $navigationSort = 3;

    public static function getNavigationGroup(): ?string   { return __('admin.nav_group.club'); }
    public static function getNavigationLabel(): string    { return __('admin.nav.board_members'); }
    public static function getModelLabel(): string         { return __('admin.model.board_member'); }
    public static function getPluralModelLabel(): string   { return __('admin.model.board_members'); }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('admin.section.user_account'))
                    ->description(__('admin.section.user_account_hint'))
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label(__('admin.col.linked_user'))
                            ->options(fn (?BoardMember $record) => User::orderBy('name')
                                ->get()
                                ->filter(fn ($user) => ! $user->boardMember || $user->boardMember->id === $record?->id)
                                ->pluck('email', 'id')
                                ->prepend('— ' . __('admin.col.no_account') . ' —', '')
                            )
                            ->searchable()
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Person')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('admin.col.email'))
                            ->email(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('admin.col.sort_order'))
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.col.active'))
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Role')
                    ->schema([
                        Forms\Components\TextInput::make('role_da')
                            ->label('Role (Danish)')
                            ->required(),
                        Forms\Components\TextInput::make('role_en')
                            ->label('Role (English)')
                            ->required(),
                        Forms\Components\Textarea::make('bio_da')
                            ->label('Bio (Danish)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('bio_en')
                            ->label('Bio (English)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Photo')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Profile Photo')
                            ->helperText('Displayed as a circle on the About page. Square crop recommended.')
                            ->image()
                            ->disk('public')
                            ->directory('board-members')
                            ->imageEditor()
                            ->circleCropper()
                            ->imageEditorAspectRatios(['1:1'])
                            ->maxSize(4096)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?background=1a472a&color=fff&size=80&name='.urlencode($record->name)),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.col.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('role_da')
                    ->label(__('admin.col.role_da'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.col.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('admin.col.order'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.col.active'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('user_id')
                    ->label(__('admin.col.has_account'))
                    ->boolean()
                    ->trueIcon('heroicon-o-user-circle')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn ($record) => $record->user?->email),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardMembers::route('/'),
            'create' => Pages\CreateBoardMember::route('/create'),
            'edit' => Pages\EditBoardMember::route('/{record}/edit'),
        ];
    }
}
