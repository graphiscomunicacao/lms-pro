<?php

namespace App\Filament\Resources;

use App\Models\LearningPathGroup;
use Filament\{Forms\Components\BelongsToManyMultiSelect,
    Forms\Components\Card,
    Forms\Components\FileUpload,
    Forms\Components\Group,
    Tables,
    Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\LearningPathGroupResource\Pages;

class LearningPathGroupResource extends Resource
{
    protected static ?string $model = LearningPathGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Group::make()
                ->schema([
                    Card::make(['default' => 0])->schema([

                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->rules(['required', 'max:255', 'string'])
                            ->placeholder('Nome')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        RichEditor::make('description')
                            ->label('Descrição')
                            ->required()
                            ->rules(['nullable', 'max:255', 'string'])
                            ->placeholder('Descrição')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        FileUpload::make('cover_path')
                            ->label('Capa')
                            ->required()
                            ->rules(['image', 'max:1024'])
                            ->image()
                            ->placeholder('Selecione uma imagem')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                    ])->columns([
                        'default' => 12,
                        'sm' => 12,
                    ]),

                    Card::make()->schema([

                        TextInput::make('tries')
                            ->label('Quantidade de Tentativas (0 = ilimitado)')
                            ->rules(['required', 'numeric'])
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(99)
                            ->placeholder('Quantidade de Tentativas')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        TextInput::make('passing_score')
                            ->label('Nota minima exigida')
                            ->rules(['required', 'numeric'])
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(10)
                            ->placeholder('Nota minima para aprovação')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),


                        TextInput::make('approval_goal')
                            ->label('Meta de aprovação (%)')
                            ->rules(['required', 'numeric'])
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->placeholder('Ex. 75%')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),


                        TextInput::make('availability_time')
                            ->label('Disponivel por N dias')
                            ->rules(['nullable', 'numeric'])
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('3 dias')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        DateTimePicker::make('start_time')
                            ->rules(['nullable', 'date'])
                            ->minDate(now())
                            ->label('Data Inicio')
                            ->placeholder('Inicio')
                            ->withoutSeconds()
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        DateTimePicker::make('end_time')
                            ->rules(['nullable', 'date'])
                            ->label('Data Fim')
                            ->placeholder('Fim')
                            ->withoutSeconds()
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        BelongsToManyMultiSelect::make('categories')
                            ->label('Categorias')
                            ->relationship('categories', 'name')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                    ])->columns([
                        'default' => 12,
                        'sm' => 12,
                    ])
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Criado')
                        ->content(fn(?LearningPathGroup $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Modificado')
                        ->content(fn(?LearningPathGroup $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])
                ->columnSpan(1),

        ])->columns([
            'sm' => 3,
            'lg' => null,
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_path')->rounded(),
                Tables\Columns\TextColumn::make('name')->limit(50)->label('Nome'),
                Tables\Columns\TextColumn::make('start_time')->dateTime()->label('Data Inicio'),
                Tables\Columns\TextColumn::make('end_time')->dateTime()->label('Data Fim'),
                Tables\Columns\TextColumn::make('tries')->label('Tentativas'),
                Tables\Columns\TextColumn::make('passing_score')->label('Nota minima requirida'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LearningPathGroupResource\RelationManagers\LearningPathsRelationManager::class,
            LearningPathGroupResource\RelationManagers\TeamsRelationManager::class,
            LearningPathGroupResource\RelationManagers\JobsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLearningPathGroups::route('/'),
            'create' => Pages\CreateLearningPathGroup::route('/create'),
            'edit' => Pages\EditLearningPathGroup::route('/{record}/edit'),
        ];
    }
}
