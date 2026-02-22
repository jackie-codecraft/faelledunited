<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardMemberResource\Pages;
use App\Filament\Resources\BoardMemberResource\RelationManagers;
use App\Models\BoardMember;
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
                Forms\Components\Section::make('Person')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
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
                            ->label('Photo')
                            ->image()
                            ->directory('board-members'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role_da')
                    ->label('Role (DA)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
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
