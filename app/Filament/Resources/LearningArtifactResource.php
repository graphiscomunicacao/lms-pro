<?php

namespace App\Filament\Resources;

use App\Models\LearningArtifact;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
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

    protected static ?string $label = 'Material de Ensino';

    protected static ?string $pluralLabel = 'Materiais de Ensino';

    protected static ?string $navigationGroup = "Gerenciar conteúdo";

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
                                    ->label('Experiência Concedida')
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
                        ->rules(['file', 'max:131072'])
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
                            ->label('Capa')
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
                            ->content(fn(?LearningArtifact $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modificado')
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
                Tables\Columns\ImageColumn::make('cover_path')
                    ->rounded()
                    ->label('Capa')
                    ->extraHeaderAttributes(['style' => 'width:10px']),
                Tables\Columns\TextColumn::make('name')
                    ->limit(10)
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->enum([
                    'audio' => 'Áudio',
                    'document' => 'Documento',
                    'interactive' => 'Interativo',
                    'image' => 'Imagem',
                    'video' => 'Vídeo',
                    'externo' => 'Externo',
                    ])
                    ->label('Tipo')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('external')->label('Externo'),
                Tables\Columns\TextColumn::make('url')
                    ->limit(20)
                    ->label('Endereço'),
                Tables\Columns\TextColumn::make('size')
                    ->label('Tamanho')
                    ->alignCenter()
                    ->formatStateUsing(fn ($state): string => LearningArtifact::formatSize($state)),
            ])
            ->defaultSort('id','desc')
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Criado a partir de'),
                        Forms\Components\DatePicker::make('created_until')->label('Criado até'),
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
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'audio' => 'Áudio',
                        'document' => 'Documento',
                        'interactive' => 'Interativo',
                        'image' => 'Imagem',
                        'video' => 'Vídeo',
                        'externo' => 'Externo',
                    ])
                    ->label('Tipo')
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
