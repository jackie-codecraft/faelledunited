<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgeGroupResource\Pages;
use App\Filament\Resources\AgeGroupResource\RelationManagers;
use App\Models\AgeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgeGroupResource extends Resource
{
    protected static ?string $model = AgeGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'id')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                Forms\Components\TextInput::make('label_da')
                    ->required(),
                Forms\Components\TextInput::make('label_en')
                    ->required(),
                Forms\Components\TextInput::make('birth_year')
                    ->numeric(),
                Forms\Components\TextInput::make('gender')
                    ->required(),
                Forms\Components\Textarea::make('description_da')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_en')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('training_schedule')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('coach_info')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('label_da')
                    ->searchable(),
                Tables\Columns\TextColumn::make('label_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListAgeGroups::route('/'),
            'create' => Pages\CreateAgeGroup::route('/create'),
            'edit' => Pages\EditAgeGroup::route('/{record}/edit'),
        ];
    }
}
