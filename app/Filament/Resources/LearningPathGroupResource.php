<?php

namespace App\Filament\Resources;

use App\Models\LearningPathGroup;
use Filament\{Forms\Components\Card,
    Forms\Components\FileUpload,
    Forms\Components\Group,
    Forms\Components\MultiSelect,
    Tables,
    Forms};
use Filament\Resources\{Form, Table, Resource};
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

    protected static ?string $label = 'Agrupamento de Trilha';

    protected static ?string $pluralLabel = 'Agrupamentos de Trilhas';

    protected static ?string $navigationGroup = "Gerenciar conteúdo";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Group::make()->schema([
                Card::make()
                    ->schema([
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
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        DateTimePicker::make('start_time')
                            ->rules(['nullable', 'date'])
                            ->minDate(now())
                            ->placeholder('Data Inicial')
                            ->label('Data Inicial')
                            ->withoutSeconds()
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        DateTimePicker::make('end_time')
                            ->rules(['nullable', 'date'])
                            ->placeholder('Data Final')
                            ->label('Data Final')
                            ->withoutSeconds()
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        TextInput::make('passing_score')
                            ->rules(['required', 'numeric'])
                            ->required()
                            ->numeric()
                            ->maxValue('10')
                            ->placeholder('Nota Mínima Exigida')
                            ->label('Nota Mínima Exigida (de 0 a 10)')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        TextInput::make('tries')
                            ->rules(['required', 'numeric'])
                            ->required()
                            ->numeric()
                            ->placeholder('Máximo de Tentativas')
                            ->label('Máximo de Tentativas (0 = ilimitado)')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                    ])
                    ->columns([
                        'default' => 12,
                        'sm' => 12,
                    ]),
            ])
                ->columnSpan([
                    'sm' => 2,
                ]),

            Group::make()->schema([
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

                Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('Configurações Adicionais'),

                        MultiSelect::make('categories')
                            ->label('Categorias')
                            ->relationship('categories', 'name')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        TextInput::make('availability_time')
                            ->rules(['nullable', 'numeric'])
                            ->numeric()
                            ->placeholder('Disponível por (dias)')
                            ->label('Disponível por (dias)')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        TextInput::make('approval_goal')
                            ->rules(['required', 'numeric'])
                            ->numeric()
                            ->placeholder('Meta de Aprovação')
                            ->label('Meta de Aprovação (em %)')
                            ->maxValue('100')
                            ->columnSpan([
                                'default' => 6,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                    ])
                    ->columnSpan(1),
            ])
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
                    ->rounded()
                    ->label('Capa')
                    ->extraHeaderAttributes(['style' => 'width:10px']),
                Tables\Columns\TextColumn::make('name')->limit(50)
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tries')
                    ->label('Máximo de Tentativas')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('passing_score')
                    ->label('Nota Mínima Exigida')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('start_time')->dateTime()
                    ->label('Data Inicial')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_time')->dateTime()
                    ->label('Data Final')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date('d/m/y h:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ultima atualização')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date('d/m/y h:i'),
            ])
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

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
