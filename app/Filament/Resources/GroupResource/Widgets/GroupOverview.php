<?php

namespace App\Filament\Resources\GroupResource\Widgets;

use App\Models\Group;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class GroupOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('Total de grupos', Group::count()),
            Card::make('Média de usuarios por grupo', Group::count()),
            Card::make('Grupos criados hoje', Group::count()),
        ];
    }
}
