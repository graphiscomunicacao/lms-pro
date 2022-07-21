<?php

namespace App\Filament\Resources\LearningPathGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class LearningPathsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'learningPaths';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Trilha de Aprendizado';

    protected static ?string $pluralLabel = 'Trilhas de Aprendizado';

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

                RichEditor::make('description')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Descrição')
                    ->label('Descrição')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                FileUpload::make('cover_path')
                    ->rules(['required', 'image', 'max:1024'])
                    ->image()
                    ->required()
                    ->label('Capa')
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
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                DateTimePicker::make('end_time')
                    ->rules(['nullable', 'date'])
                    ->placeholder('Data Final')
                    ->label('Data Final')
                    ->withoutSeconds()
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                TextInput::make('availability_time')
                    ->rules(['nullable', 'numeric'])
                    ->numeric()
                    ->placeholder('Disponível por (dias)')
                    ->label('Disponível por (dias)')
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                TextInput::make('passing_score')
                    ->rules(['required', 'numeric'])
                    ->required()
                    ->numeric()
                    ->placeholder('Nota Mínima Exigida')
                    ->label('Nota Mínima Exigida (de 0 a 10)')
                    ->maxValue('10')
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                TextInput::make('tries')
                    ->rules(['required', 'numeric'])
                    ->required()
                    ->numeric()
                    ->placeholder('Máximo de Tentativas')
                    ->label('Máximo de Tentativas')
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                TextInput::make('approval_goal')
                    ->rules(['nullable', 'numeric'])
                    ->numeric()
                    ->placeholder('Meta de Aprovação')
                    ->label('Meta de Aprovação (em %)')
                    ->maxValue('100')
                    ->columnSpan([
                        'default' => 4,
                        'md' => 4,
                        'lg' => 4,
                    ]),

                Select::make('certificate_id')
                    ->rules(['required', 'exists:certificates,id'])
                    ->required()
                    ->relationship('certificate', 'name')
                    ->searchable()
                    ->placeholder('Certificado')
                    ->label('Certificado')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('experience_amount')
                    ->rules(['required'])
                    ->label('Experiência Concedida')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->placeholder('Pontos')
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
                Tables\Columns\ImageColumn::make('cover_path')->rounded()
                    ->label('Capa')
                    ->extraHeaderAttributes(['style' => 'width:10px']),
                Tables\Columns\TextColumn::make('name')->limit(50)
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('certificate.name')
                    ->label('Certificado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('availability_time')
                    ->label('Disponível por (dias)')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tries')
                    ->label('Máximo de Tentativas')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('passing_score')
                    ->label('Nota Mínima Exigida')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('approval_goal')
                    ->label('Taxa de Aprovação Esperada')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Data Inicial')
                    ->dateTime()
                    ->date('d/m/y h:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Data Final')
                    ->dateTime()
                    ->date('d/m/y h:i')
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
}
