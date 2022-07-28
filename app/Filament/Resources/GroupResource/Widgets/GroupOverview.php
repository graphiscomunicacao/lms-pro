<?php

namespace App\Filament\Resources\GroupResource\Widgets;

use App\Models\Group;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class GroupOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards(): array
    {
        return [
            Card::make('Total de Grupos:', Group::count()),

            Card::make('Média de usuários por Grupo:', Group::averageUserPerModel(Group::all())),

            Card::make('Grupos recentes (30 dias):', Group::where('created_at', '>', now()->subDays(30))->count()),
        ];
    }
}
