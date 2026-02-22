<?php

namespace App\Filament\Pages;

use App\Models\Statute;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditStatutes extends Page
{
    protected static string $view = 'filament.pages.edit-statutes';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 40;

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('admin.nav.statutes');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav_group.club');
    }

    public function getTitle(): string
    {
        return __('admin.page.statutes');
    }

    public function mount(): void
    {
        $statute = Statute::current();

        $this->form->fill([
            'content_da' => $statute->content_da,
            'content_en' => $statute->content_en,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('languages')
                    ->tabs([
                        Tab::make('🇩🇰 Dansk')
                            ->schema([
                                MarkdownEditor::make('content_da')
                                    ->label('Vedtægter (Dansk)')
                                    ->toolbarButtons([
                                        'heading',
                                        'bold',
                                        'italic',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'blockquote',
                                        'strike',
                                        'undo',
                                        'redo',
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('🇬🇧 English')
                            ->schema([
                                MarkdownEditor::make('content_en')
                                    ->label('Statutes (English)')
                                    ->toolbarButtons([
                                        'heading',
                                        'bold',
                                        'italic',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'blockquote',
                                        'strike',
                                        'undo',
                                        'redo',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Statute::updateOrCreate(
            ['id' => 1],
            [
                'content_da' => $data['content_da'] ?? '',
                'content_en' => $data['content_en'] ?? '',
            ]
        );

        Notification::make()
            ->title(__('admin.statutes.saved'))
            ->success()
            ->send();
    }
}
