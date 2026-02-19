<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Afdelinger';
    protected static ?string $modelLabel = 'Afdeling';
    protected static ?string $pluralModelLabel = 'Afdelinger';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Grundoplysninger')
                    ->schema([
                        Forms\Components\TextInput::make('name_da')
                            ->label('Navn (DA)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                if ($operation !== 'create') return;
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('name_en')
                            ->label('Navn (EN)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Department::class, 'slug', ignoreRecord: true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Rækkefølge')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktiv')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Beskrivelse')
                    ->schema([
                        Forms\Components\Textarea::make('description_da')
                            ->label('Beskrivelse (DA)')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description_en')
                            ->label('Beskrivelse (EN)')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Billede')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Hero-billede')
                            ->image()
                            ->directory('departments'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_da')
                    ->label('Navn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Rækkefølge')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktiv')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit'   => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
