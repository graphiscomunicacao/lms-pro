<?php

namespace App\Filament\Resources\TeamResource\Widgets;

use App\Models\Team;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TeamOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards():array
    {
        return [
            Card::make('Total de Equipes:', Team::count()),

            Card::make('Equipe com mais Usuários:', Team::getBiggestTeam(Team::all())),

            Card::make('Equipes recentes (30 dias):', Team::where('created_at', '>', now()->subDays(30))->count()),
        ];
    }
}
