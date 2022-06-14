<?php

namespace App\Filament\Resources\MenuItemResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MenuItemResource;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemResource::class;
}
