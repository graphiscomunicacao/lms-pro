<?php

namespace App\Filament\Resources;

use App\Models\Category;
use App\Models\SupportLink;
use Filament\{Forms\Components\Card, Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupportLinkResource\Pages;

class SupportLinkResource extends Resource
{
    protected static ?string $model = SupportLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-support';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Link de Suporte';

    protected static ?string $pluralLabel = 'Links de Suporte';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make(['default' => 0])
                ->schema([
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

                    TextInput::make('url')
                        ->rules(['required', 'url'])
                        ->url()
                        ->placeholder('Endereço')
                        ->label('Endereço')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Toggle::make('same_tab')
                        ->rules(['required', 'boolean'])
                        ->label('Mesma Aba')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('cover_path')
                        ->rules(['image', 'max:1024'])
                        ->image()
                        ->placeholder('Capa')
                        ->label('Capa')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Criado')
                        ->content(fn(?SupportLink $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Modificado')
                        ->content(fn(?SupportLink $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])
                ->columnSpan(1),
            ])
                ->columns([
                    'sm' => 3,
                    'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_path')
                    ->label('Capa')
                    ->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('url')
                    ->label('Endereço')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\BooleanColumn::make('same_tab')
                    ->label('Mesma Aba')
                    ->sortable(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupportLinks::route('/'),
            'create' => Pages\CreateSupportLink::route('/create'),
            'edit' => Pages\EditSupportLink::route('/{record}/edit'),
        ];
    }
}
