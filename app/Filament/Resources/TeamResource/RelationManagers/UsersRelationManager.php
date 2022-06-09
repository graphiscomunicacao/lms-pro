<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Illuminate\Database\Eloquent\Model;

class UsersRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Nome')
                    ->label('Nome')
                    ->required()
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->unique(ignorable: fn (?Model $record): ?Model => $record)
                    ->email()
                    ->placeholder('Email')
                    ->required()
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                BelongsToSelect::make('role_id')
                    ->rules(['required', 'exists:roles,id'])
                    ->relationship('role', 'name')
                    ->searchable()
                    ->placeholder('Perfil')
                    ->label('Perfil')
                    ->required()
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                BelongsToSelect::make('job_id')
                    ->rules(['required', 'exists:jobs,id'])
                    ->relationship('job', 'name')
                    ->searchable()
                    ->placeholder('Cargo')
                    ->label('Cargo')
                    ->required()
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                BelongsToSelect::make('manager_id')
                    ->rules(['nullable', 'exists:users,id'])
                    ->relationship('manager', 'name')
                    ->searchable()
                    ->placeholder('Responsável')
                    ->label('Responsável')
                    ->required()
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                BelongsToSelect::make('group_id')
                    ->rules(['exists:groups,id'])
                    ->relationship('group', 'name')
                    ->searchable()
                    ->placeholder('Grupo')
                    ->label('Grupo')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nome')
                    ->limit(50),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('manager.name')
                    ->sortable()
                    ->searchable()
                    ->label('Responsável')
                    ->limit(50),
            ])
            ->defaultSort('name')
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

                MultiSelectFilter::make('role_id')->relationship(
                    'role',
                    'name'
                ),

                MultiSelectFilter::make('job_id')->relationship('job', 'name'),
            ]);
    }
}
