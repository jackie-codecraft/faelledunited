<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Registrations';
    protected static ?string $navigationGroup = 'Members';
    protected static ?int    $navigationSort = 1;
    protected static ?string $modelLabel = 'Registration';
    protected static ?string $pluralModelLabel = 'Registrations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'id')
                    ->required(),
                Forms\Components\Select::make('age_group_id')
                    ->relationship('ageGroup', 'id')
                    ->required(),
                Forms\Components\TextInput::make('player_name')
                    ->required(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
                Forms\Components\TextInput::make('current_club_experience'),
                Forms\Components\TextInput::make('parent_name')
                    ->required(),
                Forms\Components\TextInput::make('parent_email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required(),
                Forms\Components\Textarea::make('additional_info')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('gdpr_consent')
                    ->required(),
                Forms\Components\Toggle::make('photo_consent')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('internal_notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ageGroup.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('player_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_club_experience')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('gdpr_consent')
                    ->boolean(),
                Tables\Columns\IconColumn::make('photo_consent')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
