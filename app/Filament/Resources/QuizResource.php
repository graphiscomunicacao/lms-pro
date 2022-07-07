<?php

namespace App\Filament\Resources;

use App\Models\Quiz;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mockery\Matcher\Closure;
use Filament\{Forms\Components\Card, Forms\Components\Group, Forms\Components\TimePicker, Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\QuizResource\Pages;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = "Quiz";

    protected static ?string $navigationGroup = "Gerenciar conteúdo";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Card::make(['default' => 0])
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nome')
                                    ->rules(['required', 'max:255', 'string'])
                                    ->required()
                                    ->placeholder('Nome do Quiz')
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                    ]),

                                RichEditor::make('description')
                                    ->label('Descrição')
                                    ->rules(['nullable', 'max:255', 'string'])
                                    ->placeholder('Description')
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                    ]),

                                FileUpload::make('cover_path')
                                    ->label('Capa')
                                    ->rules(['image', 'max:1024'])
                                    ->image()
                                    ->directory('/img/covers/')
                                    ->required()
                                    ->placeholder('Selecione uma imagem')
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                    ]),

                            ])
                            ->columns([
                                'default' => 12,
                                'sm' => 12,
                            ])
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        Card::make(['default' => 0])
                            ->schema([

                                TextInput::make('time_limit')
                                    ->label('Tempo de realização (minutos)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(5)
                                    ->required()
                                    ->placeholder('Time Limit')
                                    ->columnSpan([
                                        'default' => 6,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                                TextInput::make('experience_amount')
                                    ->label('Experiência concedida')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(10)
                                    ->placeholder('Experience')
                                    ->columnSpan([
                                        'default' => 6,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),


                            ])
                            ->columns([
                                'default' => 12,
                                'sm' => 12,
                            ])
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Criado')
                            ->content(fn(?Quiz $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modificado')
                            ->content(fn(?Quiz $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                Tables\Columns\ImageColumn::make('cover_path')->rounded()->label('Capa')
                    ->extraHeaderAttributes(['style' => 'width:10px']),
                Tables\Columns\TextColumn::make('name')->limit(50)->label('Nome'),
                Tables\Columns\TextColumn::make('time_limit')
                    ->label('Tempo para realização')
                    ->formatStateUsing(fn (string $state): string => date('H:i', mktime(0,$state)) ),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->sortable()
                    ->date('d/m/y h:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ultima atualização')
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
            QuizResource\RelationManagers\ObjectiveQuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
