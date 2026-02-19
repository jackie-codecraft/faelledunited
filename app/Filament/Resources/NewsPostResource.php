<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsPostResource\Pages;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsPostResource extends Resource
{
    protected static ?string $model = NewsPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Nyheder';
    protected static ?string $modelLabel = 'Nyhed';
    protected static ?string $pluralModelLabel = 'Nyheder';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Publicering')
                    ->schema([
                        Forms\Components\Select::make('news_category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name_da')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publiceret')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publiceringsdato')
                            ->native(false),
                    ])->columns(3),

                Forms\Components\Section::make('Dansk indhold')
                    ->schema([
                        Forms\Components\TextInput::make('title_da')
                            ->label('Titel (DA)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                if ($operation !== 'create') return;
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(NewsPost::class, 'slug', ignoreRecord: true)
                            ->helperText('Auto-genereret fra titel. Kan ændres manuelt.'),
                        Forms\Components\Textarea::make('excerpt_da')
                            ->label('Uddrag (DA)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('body_da')
                            ->label('Brødtekst (DA) — Markdown')
                            ->required()
                            ->rows(12)
                            ->columnSpanFull()
                            ->helperText('Brug Markdown-formatering: **fed**, *kursiv*, ## overskrift, osv.'),
                    ])->columns(2),

                Forms\Components\Section::make('Engelsk indhold')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Titel (EN)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt_en')
                            ->label('Uddrag (EN)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('body_en')
                            ->label('Brødtekst (EN) — Markdown')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible()->collapsed(),

                Forms\Components\Section::make('Billede')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Forsidebillede')
                            ->image()
                            ->directory('news')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_da')
                    ->label('Titel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name_da')
                    ->label('Kategori')
                    ->badge()
                    ->color('success'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publiceret')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Dato')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oprettet')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Publiceret'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNewsPosts::route('/'),
            'create' => Pages\CreateNewsPost::route('/create'),
            'edit'   => Pages\EditNewsPost::route('/{record}/edit'),
        ];
    }
}
