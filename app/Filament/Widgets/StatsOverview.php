<?php

namespace App\Filament\Widgets;

use App\Models\Kader;
use App\Models\KaderisasiEvent;
use App\Models\Pac;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Role;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All users in the system')
                ->icon('heroicon-o-users'),
            Stat::make('Total Roles', Role::count())
                ->description('All roles available')
                ->icon('heroicon-o-shield-check'),
            Stat::make('Total PAC', Pac::count())
                ->description('All PAC registered')
                ->icon('heroicon-o-building-office-2'),
            Stat::make('Total Kader', Kader::count())
                ->description('All kader registered')
                ->icon('heroicon-o-user-group'),
            Stat::make('Kaderisasi Events', KaderisasiEvent::count())
                ->description('All kaderisasi events')
                ->icon('heroicon-o-calendar-days'),
            Stat::make('Unread Notifications', auth()->user()->unreadNotifications()->count())
                ->description('Your unread notifications')
                ->icon('heroicon-o-bell-alert'),
        ];
    }
}