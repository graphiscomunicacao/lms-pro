<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Widgets\GroupOverview;
use App\Models\Group;
use Filament\{Forms\Components\Card, Tables, Forms, Tables\Filters\TernaryFilter};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GroupResource\Pages;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Grupo';

    protected static ?string $navigationGroup = "Gerenciar usuários";

    public static function getWidgets(): array
    {
        return [
            GroupOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema(Card::class))
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->defaultSort('name')
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Criado a partir de'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Criado até'),
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
                TernaryFilter::make('trashed')
                    ->label('Exibir')
                    ->placeholder('Apenas registros ativos')
                    ->trueLabel('Registros ativos e excluidos')
                    ->falseLabel('Apenas registros excluidos')
                    ->queries(
                        true: fn(Builder $query) => $query->withTrashed(),
                        false: fn(Builder $query) => $query->onlyTrashed(),
                        blank: fn(Builder $query) => $query->withoutTrashed(),
                    )
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->limit(50)
                ->label('Nome')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em')
                ->sortable()
                ->date('d/m/y h:i'),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Ultima atualização')
                ->sortable()
                ->date('d/m/y h:i'),
            Tables\Columns\IconColumn::make('deleted_at')
                ->options([
                    'heroicon-o-check-circle' => fn($state): bool => $state === NULL,
                    'heroicon-o-x-circle' => fn($state): bool => $state !== NULL,
                ])
                ->colors([
                    'success' => fn($state): bool => $state === NULL,
                    'danger' => fn($state): bool => $state !== NULL,
                ])
                ->label('Status')
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }

    public static function getFormSchema(string $layout = Forms\Components\Grid::class): array
    {
        return [
            Forms\Components\Group::make()
                ->schema([
                    $layout::make(['default' => 0])
                        ->schema([
                            TextInput::make('name')
                                ->rules(['required', 'max:255', 'string'])
                                ->placeholder('Nome')
                                ->label('Nome')
                                ->required(),
                        ]),
                ])->columnSpan([
                    'sm' => 2,
                ]),
            Forms\Components\Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Criado')
                                ->content(fn(?Group $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Modificado')
                                ->content(fn(?Group $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ])->columnSpan([
                            'sm' => 1,
                        ]),
                ])
                ->columnSpan(1)
        ];
    }
}
