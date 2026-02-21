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
                Forms\Components\Section::make('Sign-up Details')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name_da')
                            ->required(),
                        Forms\Components\Select::make('age_group_id')
                            ->label('Age Group / Team')
                            ->relationship('ageGroup', 'label_da')
                            ->required(),
                        Forms\Components\TextInput::make('status')
                            ->label('Status')
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
                            ->label('Name')
                            ->required(),
                        Forms\Components\TextInput::make('parent_email')
                            ->label('Email')
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
                    ->label('Department')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ageGroup.label_da')
                    ->label('Team')
                    ->sortable(),
                Tables\Columns\TextColumn::make('player_name')
                    ->label('Child')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Born')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent_name')
                    ->label('Parent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('gdpr_consent')
                    ->label('GDPR')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
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
