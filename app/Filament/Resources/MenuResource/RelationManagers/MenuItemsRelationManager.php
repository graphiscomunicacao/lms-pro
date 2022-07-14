<?php

namespace App\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class MenuItemsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'menuItems';

    protected static ?string $recordTitleAttribute = 'item_type';

    protected static ?string $label = 'Vincular Item';

    protected static ?string $pluralLabel = 'Vincular Itens';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                Select::make('item_type')
                    ->label('Tipo de Item')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Selecione')
                    ->options([
                        'App\Models\SupportLink' => 'Link de Apoio',
                        'App\Models\LearningArtifact' => 'Material de Ensino',
                        'App\Models\Quiz' => 'Quiz',
                        'App\Models\LearningPath' => 'Trilha de Ensino',
                        'App\Models\LearningPathGroup' => 'Grupo de Trilhas de Ensino',
                    ])
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('item_id')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Item Id')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu.name')->limit(50),
                Tables\Columns\TextColumn::make('item_type')->limit(50),
                Tables\Columns\TextColumn::make('item_id'),
                Tables\Columns\TextColumn::make('order'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('menu_id')->relationship(
                    'menu',
                    'name'
                ),
            ]);
    }
}
