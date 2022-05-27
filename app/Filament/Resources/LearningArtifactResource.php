<?php

namespace App\Filament\Resources;

use App\Models\LearningArtifact;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LearningArtifactResource\Pages;
use Closure;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\Card;

class LearningArtifactResource extends Resource
{
    protected static ?string $model = LearningArtifact::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public $data;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make(['default' => 0])
                    ->schema([
                        TextInput::make('name')
                            ->rules(['required', 'max:255', 'string'])
                            ->placeholder('Name')
                            ->label('Nome')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        BelongsToManyMultiSelect::make('categories')
                            ->label('Categorias')
                            ->relationship('categories', 'name')
                            ->columnSpan([
                                        'default' => 6,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                        TextInput::make('experience_amount')
                                    ->rules(['required'])
                                    ->label('Experiência concedida')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(10)
                                    ->placeholder('Pontos')
                                    ->columnSpan([
                                        'default' => 6,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),



                        RichEditor::make('description')
                            ->rules(['nullable', 'max:255', 'string'])
                            ->label('Descrição')
                            ->placeholder('Descrição')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        Toggle::make('external')
                            ->rules(['required', 'boolean'])
                            ->label('Conteúdo externo')
                            ->reactive()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        FileUpload::make('path')
                        ->rules(['file'])
                        ->label('Selecione o arquivo')
                        ->placeholder('Arquivo')
                        ->visible(fn (Closure $get) => $get('external') === false)
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                        TextInput::make('url')
                            ->rules(['nullable', 'url'])
                            ->url()
                            ->placeholder('Url')
                            ->visible(fn (Closure $get) => $get('external') === true)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),

                        FileUpload::make('cover_path')
                            ->rules(['required','image', 'max:1024'])
                            ->image()
                            ->placeholder('Cover Path')
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
                            ->label('Created at')
                            ->content(fn(?LearningArtifact $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn(?LearningArtifact $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                Tables\Columns\ImageColumn::make('cover_path')->rounded()->label('Capa'),
                Tables\Columns\TextColumn::make('name')->limit(10)->label('Nome')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')->enum([
                    'audio' => 'Audio',
                    'document' => 'Document',
                    'interactive' => 'Interactive',
                    'image' => 'Image',
                    'video' => 'Video',
                    'externo' => 'Externo',
                ])->label('Tipo'),
                Tables\Columns\TextColumn::make('size')->label('Tamanho'),
                Tables\Columns\BooleanColumn::make('external')->label('Externo'),
                Tables\Columns\TextColumn::make('url')->limit(20),
            ])
            ->defaultSort('id','desc')
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
            'index' => Pages\ListLearningArtifacts::route('/'),
            'create' => Pages\CreateLearningArtifact::route('/create'),
            'edit' => Pages\EditLearningArtifact::route('/{record}/edit'),
        ];
    }
}
