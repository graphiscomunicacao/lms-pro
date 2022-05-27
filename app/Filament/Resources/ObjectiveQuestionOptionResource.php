<?php

namespace App\Filament\Resources;

use App\Models\ObjectiveQuestionOption;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\ObjectiveQuestionOptionResource\Pages;

class ObjectiveQuestionOptionResource extends Resource
{
    protected static ?string $model = ObjectiveQuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'body';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                RichEditor::make('body')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Body')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Toggle::make('is_correct')
                    ->rules(['required', 'boolean'])
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                BelongsToSelect::make('objective_question_id')
                    ->rules(['required', 'exists:objective_questions,id'])
                    ->relationship('objectiveQuestion', 'body')
                    ->searchable()
                    ->placeholder('Objective Question')
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
                Tables\Columns\TextColumn::make('body')->limit(50),
                Tables\Columns\BooleanColumn::make('is_correct'),
                Tables\Columns\TextColumn::make(
                    'objectiveQuestion.body'
                )->limit(50),
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

                MultiSelectFilter::make('objective_question_id')->relationship(
                    'objectiveQuestion',
                    'body'
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ObjectiveQuestionOptionResource\RelationManagers\ObjectiveAnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListObjectiveQuestionOptions::route('/'),
            'create' => Pages\CreateObjectiveQuestionOption::route('/create'),
            'edit' => Pages\EditObjectiveQuestionOption::route(
                '/{record}/edit'
            ),
        ];
    }
}
