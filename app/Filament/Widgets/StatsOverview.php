<?php

namespace App\Filament\Widgets;

use App\Models\LearningArtifact;
use App\Models\Setting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $totalSpace = Setting::maxStorageSize();
        $usedSpace = LearningArtifact::sum('size');
        $freeSpace = $totalSpace - $usedSpace;

        return [
            Card::make('Espaço em Uso:',
                LearningArtifact::formatSize($usedSpace))
                ->description('Espaço livre: ' . LearningArtifact::formatSize($freeSpace) .
                    ', do Total de: ' . LearningArtifact::formatSize($totalSpace))
                ->descriptionIcon('heroicon-o-chart-pie'),
        ];
    }
}
