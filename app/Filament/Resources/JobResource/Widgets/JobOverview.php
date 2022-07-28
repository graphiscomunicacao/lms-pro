<?php

namespace App\Filament\Resources\JobResource\Widgets;

use App\Models\Job;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class JobOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards(): array
    {
        return [
            Card::make('Total de Cargos:', Job::count()),

            Card::make('Média de usuários por Cargo:', Job::averageUserPerModel(Job::all())),

            Card::make('Cargos recentes (30 dias):', Job::where('created_at', '>', now()->subDays(30))->count()),
        ];
    }
}
