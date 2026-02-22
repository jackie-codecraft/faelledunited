<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgeGroupResource\Pages;
use App\Models\AgeGroup;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AgeGroupResource extends Resource
{
    protected static ?string $model = AgeGroup::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int    $navigationSort = 2;

    public static function getNavigationGroup(): ?string   { return __('admin.nav_group.club'); }
    public static function getNavigationLabel(): string    { return __('admin.nav.age_groups'); }
    public static function getModelLabel(): string         { return __('admin.model.age_group'); }
    public static function getPluralModelLabel(): string   { return __('admin.model.age_groups'); }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Basic Info')->schema([
                Forms\Components\Select::make('department_id')
                    ->label(__('admin.col.department'))
                    ->relationship('department', 'name_da')
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('URL-friendly identifier, e.g. 2012-piger'),

                Forms\Components\TextInput::make('label_da')
                    ->label('Name (Danish)')
                    ->required(),

                Forms\Components\TextInput::make('label_en')
                    ->label('Name (English)')
                    ->required(),

                Forms\Components\Select::make('gender')
                    ->options(['boys' => 'Boys (Drenge)', 'girls' => 'Girls (Piger)', 'mixed' => 'Mixed'])
                    ->required(),

                Forms\Components\TextInput::make('birth_year')
                    ->label(__('admin.col.birth_year'))
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2025),

                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_active')
                    ->label(__('admin.col.active'))
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\Textarea::make('description_da')
                    ->label('Description (Danish)')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description_en')
                    ->label('Description (English)')
                    ->rows(4)
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make(fn () => __('admin.section.training_schedule'))
                ->description(fn () => __('admin.section.training_schedule_desc'))
                ->schema([
                    Forms\Components\Repeater::make('training_schedule')
                        ->label('')
                        ->schema([
                            Forms\Components\Select::make('day')
                                ->label(fn () => __('admin.col.day'))
                                ->options(fn () => [
                                    'monday'    => __('days.monday'),
                                    'tuesday'   => __('days.tuesday'),
                                    'wednesday' => __('days.wednesday'),
                                    'thursday'  => __('days.thursday'),
                                    'friday'    => __('days.friday'),
                                    'saturday'  => __('days.saturday'),
                                    'sunday'    => __('days.sunday'),
                                ])
                                ->required(),

                            Forms\Components\TextInput::make('time')
                                ->label(fn () => __('admin.col.time'))
                                ->placeholder('10:30 – 12:00')
                                ->required(),

                            Forms\Components\TextInput::make('location')
                                ->label(fn () => __('admin.col.location'))
                                ->placeholder('Byparken'),

                            Forms\Components\TextInput::make('notes')
                                ->label(fn () => __('admin.col.notes'))
                                ->placeholder(__('admin.placeholder.optional')),
                        ])
                        ->columns(4)
                        ->addActionLabel(fn () => __('admin.action.add_session'))
                        ->defaultItems(0)
                        ->reorderable()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Coach Info')
                ->description('Coach contact details')
                ->schema([
                    Forms\Components\KeyValue::make('coach_info')
                        ->label('Coach info fields')
                        ->helperText('Keys: name, email, phone, note')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.name_da')
                    ->label(__('admin.col.department'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('label_da')
                    ->label(__('admin.col.name_da'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boys' => 'info',
                        'girls' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('birth_year')
                    ->label(__('admin.col.birth_year'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.col.active'))
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name_da'),
                Tables\Filters\SelectFilter::make('gender')
                    ->options(['boys' => 'Boys', 'girls' => 'Girls', 'mixed' => 'Mixed']),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgeGroups::route('/'),
            'create' => Pages\CreateAgeGroup::route('/create'),
            'edit' => Pages\EditAgeGroup::route('/{record}/edit'),
        ];
    }
}
