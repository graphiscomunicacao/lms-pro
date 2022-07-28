<?php

namespace App\Filament\Resources\RoleResource\Widgets;

use App\Models\Role;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class RoleOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards():array
    {
        return [
            Card::make('Total de Perfis:', Role::count()),

            Card::make('Média de usuários por Perfil:', Role::averageUserPerModel(Role::all())),

            Card::make('Perfis recentes (30 dias):', Role::where('created_at', '>', now()->subDays(30))->count()),
        ];
    }
}
