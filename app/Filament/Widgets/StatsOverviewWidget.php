<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use App\Models\NewsletterSubscriber;
use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $openInquiries    = ContactInquiry::where('status', 'new')->count();
        $newRegistrations = Registration::where('status', 'new')->count();
        $subscribers      = NewsletterSubscriber::where('confirmed', true)->count();
        $totalRegs        = Registration::count();

        return [
            Stat::make(__('admin.dashboard.open_inquiries'), $openInquiries)
                ->description($openInquiries > 0
                    ? __('admin.dashboard.stat_desc.inquiries_pending')
                    : __('admin.dashboard.stat_desc.all_clear'))
                ->color($openInquiries > 0 ? 'warning' : 'success')
                ->icon($openInquiries > 0 ? 'heroicon-o-chat-bubble-left-ellipsis' : 'heroicon-o-check-circle')
                ->url(route('filament.admin.resources.contact-inquiries.index', ['tableFilters[status][value]' => 'new'])),

            Stat::make(__('admin.dashboard.new_registrations'), $newRegistrations)
                ->description($newRegistrations > 0
                    ? __('admin.dashboard.stat_desc.registrations_pending')
                    : __('admin.dashboard.stat_desc.all_clear'))
                ->color($newRegistrations > 0 ? 'warning' : 'success')
                ->icon($newRegistrations > 0 ? 'heroicon-o-clipboard-document-list' : 'heroicon-o-check-circle')
                ->url(route('filament.admin.resources.registrations.index')),

            Stat::make(__('admin.dashboard.mailing_list'), $subscribers)
                ->description(__('admin.dashboard.stat_desc.confirmed_subscribers'))
                ->color('info')
                ->icon('heroicon-o-envelope')
                ->url(route('filament.admin.resources.newsletter-subscribers.index')),

            Stat::make(__('admin.dashboard.total_registrations'), $totalRegs)
                ->description(__('admin.dashboard.stat_desc.all_time'))
                ->color('gray')
                ->icon('heroicon-o-users')
                ->url(route('filament.admin.resources.registrations.index')),
        ];
    }
}
