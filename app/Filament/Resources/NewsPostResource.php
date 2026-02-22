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
    protected static ?int    $navigationSort = 1;

    public static function getNavigationGroup(): ?string   { return __('admin.nav_group.news'); }
    public static function getNavigationLabel(): string    { return __('admin.nav.posts'); }
    public static function getModelLabel(): string         { return __('admin.model.post'); }
    public static function getPluralModelLabel(): string   { return __('admin.model.posts'); }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Select::make('news_category_id')
                            ->label('Category')
                            ->relationship('category', 'name_da')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->native(false),
                    ])->columns(3),

                Forms\Components\Section::make('Danish Content')
                    ->schema([
                        Forms\Components\TextInput::make('title_da')
                            ->label('Title (Danish)')
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
                            ->helperText('Auto-generated from title. Can be changed manually.'),
                        Forms\Components\Textarea::make('excerpt_da')
                            ->label('Excerpt (Danish)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('body_da')
                            ->label('Body (Danish) — Markdown')
                            ->required()
                            ->rows(12)
                            ->columnSpanFull()
                            ->helperText('Use Markdown: **bold**, *italic*, ## heading, etc.'),
                    ])->columns(2),

                Forms\Components\Section::make('English Content')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt_en')
                            ->label('Excerpt (English)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('body_en')
                            ->label('Body (English) — Markdown')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible()->collapsed(),

                Forms\Components\Section::make('Image')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Featured Image')
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
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name_da')
                    ->label('Category')
                    ->badge()
                    ->color('success'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Date')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
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
