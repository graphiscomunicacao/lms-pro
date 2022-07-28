<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UserOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards(): array
    {
        return [
            Card::make('Total de Usuários', User::count()),

            Card::make('Usuários recentes (30 dias)', User::where('created_at', '>', now()->subDays(30))->count()),
        ];
    }
}
