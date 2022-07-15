<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearningArtifactResource\Widgets\LearningArtifactOverview;
use App\Models\LearningArtifact;
use Filament\{Forms\Components\Group, Forms\Components\MultiSelect, Tables, Forms, Tables\Filters\SelectFilter};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LearningArtifactResource\Pages;
use Closure;
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

    public static function getWidgets(): array
    {
        return [
            LearningArtifactOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Card::make()
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
                                    ->required()
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
                                    ->required()
                                    ->visible(fn (Closure $get) => $get('external') === false)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                    ]),

                                TextInput::make('url')
                                    ->rules(['nullable', 'url'])
                                    ->url()
                                    ->required()
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
                                    ->required()
                                    ->label('Capa')
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
                ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),

                Group::make()
                    ->schema([
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

                        Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('Configurações Adicionais'),

                                MultiSelect::make('categories')
                                    ->label('Categorias')
                                    ->relationship('categories', 'name'),

                                TextInput::make('experience_amount')
                                    ->rules(['required'])
                                    ->required()
                                    ->label('Experiência Concedida')
                                    ->numeric()
                                    ->minValue(0)
                                    ->placeholder('Pontos'),
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
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BooleanColumn::make('external')
                    ->label('Externo')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('url')
                    ->limit(20)
                    ->label('Endereço')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Tamanho')
                    ->alignCenter()
                    ->toggleable()
                    ->formatStateUsing(fn ($state): string => LearningArtifact::formatSize($state)),
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
            ->defaultSort('id','desc')
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
                SelectFilter::make('type')
                    ->options([
                        'audio' => 'Áudio',
                        'document' => 'Documento',
                        'interactive' => 'Interativo',
                        'image' => 'Imagem',
                        'video' => 'Vídeo',
                        'externo' => 'Externo',
                    ])
                    ->label('Tipo'),

                SelectFilter::make('external')
                    ->label('Externo')
                    ->options([
                        '0' => 'Não',
                        '1' => 'Sim',
                    ]),
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

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
