<?php

namespace App\Filament\Resources;

use App\Models\ObjectiveQuestion;
use Filament\{Forms\Components\HasManyRepeater, Forms\Components\TextInput, Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ObjectiveQuestionResource\Pages;

class ObjectiveQuestionResource extends Resource
{
    protected static ?string $model = ObjectiveQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'body';

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

                RichEditor::make('answer_explanation')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Answer Explanation')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Toggle::make('multi_option')
                    ->rules(['nullable', 'boolean'])
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                HasManyRepeater::make('objectiveQuestionOptions')
                    ->relationship('objectiveQuestionOptions')
                    ->schema([
                        TextInput::make('body')
                            ->label('Alternativa')
                            ->placeholder('Alternativa')
                            ->columnSpan([
                                'md' => 12,
                            ])
                            ->required(),
                        Toggle::make('is_correct')
                            ->label('Alternativa Correta')
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
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('body')->limit(50),
                Tables\Columns\TextColumn::make('answer_explanation')->limit(
                    50
                ),
                Tables\Columns\BooleanColumn::make('multi_option'),
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
//            ObjectiveQuestionResource\RelationManagers\ObjectiveQuestionOptionsRelationManager::class,
//            ObjectiveQuestionResource\RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListObjectiveQuestions::route('/'),
            'create' => Pages\CreateObjectiveQuestion::route('/create'),
            'edit' => Pages\EditObjectiveQuestion::route('/{record}/edit'),
        ];
    }
}
