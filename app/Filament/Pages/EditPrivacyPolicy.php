<?php

namespace App\Filament\Pages;

use App\Models\PrivacyPolicy;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditPrivacyPolicy extends Page
{
    protected static string $view = 'filament.pages.edit-privacy-policy';

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = 50;

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('admin.nav.privacy_policy');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav_group.club');
    }

    public function getTitle(): string
    {
        return __('admin.page.privacy_policy');
    }

    public function mount(): void
    {
        $policy = PrivacyPolicy::current();

        $this->form->fill([
            'content_da' => $policy->content_da,
            'content_en' => $policy->content_en,
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
                                    ->label('Privatlivspolitik (Dansk)')
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
                                    ->label('Privacy Policy (English)')
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

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'content_da' => $data['content_da'] ?? '',
                'content_en' => $data['content_en'] ?? '',
            ]
        );

        Notification::make()
            ->title(__('admin.privacy_policy.saved'))
            ->success()
            ->send();
    }
}
