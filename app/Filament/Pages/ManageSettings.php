<?php

namespace App\Filament\Pages;

use App\Models\SiteSettings;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 110;

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('admin.nav.settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav_group.administration');
    }

    public function getTitle(): string
    {
        return __('admin.page.settings');
    }

    public function mount(): void
    {
        $s = SiteSettings::current();

        $this->form->fill([
            'contact_email'                  => $s->contact_email,
            'default_inquiry_assignee_id'    => $s->default_inquiry_assignee_id,
            'registration_open'              => $s->registration_open,
            'registration_closed_message_da' => $s->registration_closed_message_da,
            'registration_closed_message_en' => $s->registration_closed_message_en,
            'facebook_url'                   => $s->facebook_url,
            'instagram_url'                  => $s->instagram_url,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── Contact ──────────────────────────────────────────────────
                Section::make(__('admin.settings.section.contact'))
                    ->schema([
                        TextInput::make('contact_email')
                            ->label(__('admin.settings.contact_email'))
                            ->email()
                            ->required()
                            ->helperText(__('admin.settings.contact_email_hint'))
                            ->columnSpanFull(),

                        Select::make('default_inquiry_assignee_id')
                            ->label(__('admin.settings.default_assignee'))
                            ->helperText(__('admin.settings.default_assignee_hint'))
                            ->options(fn () => User::orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('— ' . __('admin.col.unassigned') . ' —')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                // ── Registration ─────────────────────────────────────────────
                Section::make(__('admin.settings.section.registration'))
                    ->schema([
                        Toggle::make('registration_open')
                            ->label(__('admin.settings.registration_open'))
                            ->helperText(__('admin.settings.registration_open_hint'))
                            ->columnSpanFull(),

                        Tabs::make('closed_message')
                            ->tabs([
                                Tab::make('🇩🇰 Dansk')
                                    ->schema([
                                        Textarea::make('registration_closed_message_da')
                                            ->label(__('admin.settings.closed_message'))
                                            ->helperText(__('admin.settings.closed_message_hint'))
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('🇬🇧 English')
                                    ->schema([
                                        Textarea::make('registration_closed_message_en')
                                            ->label(__('admin.settings.closed_message'))
                                            ->helperText(__('admin.settings.closed_message_hint'))
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),

                // ── Social ───────────────────────────────────────────────────
                Section::make(__('admin.settings.section.social'))
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->prefixIcon('heroicon-o-link')
                            ->placeholder('https://www.facebook.com/groups/...')
                            ->nullable(),

                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->prefixIcon('heroicon-o-link')
                            ->placeholder('https://www.instagram.com/...')
                            ->nullable(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSettings::updateOrCreate(['id' => 1], $data);

        Notification::make()
            ->title(__('admin.settings.saved'))
            ->success()
            ->send();
    }
}
