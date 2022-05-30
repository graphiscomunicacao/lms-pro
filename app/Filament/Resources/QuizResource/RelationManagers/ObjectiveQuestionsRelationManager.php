<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class ObjectiveQuestionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'objectiveQuestions';

    protected static ?string $recordTitleAttribute = 'body';

    protected static ?string $label = "Questão Objetiva";

    protected static ?string $title = "Questões Objetivas";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('body')
                    ->label('Questão')
                    ->rules(['max:255', 'string'])
                    ->required()
                    ->placeholder('Texto da Questão Objetiva')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                HasManyRepeater::make('objectiveQuestionOptions')
                    ->relationship('objectiveQuestionOptions')
                    ->label('Alternativas')
                    ->schema([
                        TextInput::make('body')
                            ->label('Alternativa')
                            ->placeholder('Texto da Alternativa')
                            ->columnSpan([
                                'md' => 12,
                            ])
                            ->required(),
                        Toggle::make('is_correct')
                            ->label('Correta')
                            ->columnSpan([
                                'md' => 12,
                            ]),
                    ])
                    ->columns([
                        'md' => 12,
                    ])
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])
                    ->required(),

                RichEditor::make('answer_explanation')
                    ->label('Explicação da Resposta')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Answer Explanation')
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
                Tables\Columns\TextColumn::make('body')->label('Questão')->limit(50),
                Tables\Columns\TextColumn::make('answer_explanation')->label('Explicação da Resposta')
                    ->limit(50)
                    ->html(),
                Tables\Columns\BooleanColumn::make('multi_option')->label('Milti Resposta'),
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
}
