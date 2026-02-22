<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class NewRegistrationsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('admin.dashboard.new_registrations'))
            ->query(
                Registration::query()
                    ->where('created_at', '>=', now()->subDays(30))
                    ->orderByDesc('created_at')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('player_name')
                    ->label(__('admin.col.child'))
                    ->searchable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('parent_name')
                    ->label(__('admin.col.parent'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('parent_email')
                    ->label(__('admin.col.email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.name_da')
                    ->label(__('admin.col.department'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.col.submitted'))
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('admin.action.view'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (Registration $record): string => route(
                        'filament.admin.resources.registrations.edit',
                        ['record' => $record]
                    )),
            ])
            ->headerActions([
                Tables\Actions\Action::make('view_all_registrations')
                    ->label(__('admin.dashboard.view_all'))
                    ->url(route('filament.admin.resources.registrations.index'))
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->size('sm'),
            ])
            ->paginated(false)
            ->emptyStateIcon('heroicon-o-check-circle')
            ->emptyStateHeading(__('admin.dashboard.all_clear_registrations'))
            ->emptyStateDescription(__('admin.dashboard.empty_desc.no_recent_regs'));
    }
}
