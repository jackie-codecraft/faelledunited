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
    protected static ?int    $navigationSort = 1;

    public static function getNavigationGroup(): ?string   { return __('admin.nav_group.members'); }
    public static function getNavigationLabel(): string    { return __('admin.nav.registrations'); }
    public static function getModelLabel(): string         { return __('admin.model.registration'); }
    public static function getPluralModelLabel(): string   { return __('admin.model.registrations'); }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sign-up Details')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->label(__('admin.col.department'))
                            ->relationship('department', 'name_da')
                            ->required(),
                        Forms\Components\Select::make('age_group_id')
                            ->label('Age Group / Team')
                            ->relationship('ageGroup', 'label_da')
                            ->required(),
                        Forms\Components\TextInput::make('status')
                            ->label(__('admin.col.status'))
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Child')
                    ->schema([
                        Forms\Components\TextInput::make('player_name')
                            ->label('Full Name')
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->required(),
                        Forms\Components\TextInput::make('current_club_experience')
                            ->label('Previous Club / Experience'),
                    ])->columns(3),

                Forms\Components\Section::make('Parent / Guardian')
                    ->schema([
                        Forms\Components\TextInput::make('parent_name')
                            ->label(__('admin.col.name'))
                            ->required(),
                        Forms\Components\TextInput::make('parent_email')
                            ->label(__('admin.col.email'))
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('address')
                            ->label('Address')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Consents & Notes')
                    ->schema([
                        Forms\Components\Toggle::make('gdpr_consent')
                            ->label('GDPR Consent')
                            ->required(),
                        Forms\Components\Toggle::make('photo_consent')
                            ->label('Photo Consent')
                            ->required(),
                        Forms\Components\Textarea::make('additional_info')
                            ->label('Message from Parent')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('internal_notes')
                            ->label('Internal Notes')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.name_da')
                    ->label(__('admin.col.department'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ageGroup.label_da')
                    ->label(__('admin.col.team'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('player_name')
                    ->label(__('admin.col.child'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label(__('admin.col.born'))
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent_name')
                    ->label(__('admin.col.parent'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_email')
                    ->label(__('admin.col.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin.col.status'))
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('gdpr_consent')
                    ->label(__('admin.col.gdpr'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.col.submitted'))
                    ->dateTime('d/m/Y')
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
