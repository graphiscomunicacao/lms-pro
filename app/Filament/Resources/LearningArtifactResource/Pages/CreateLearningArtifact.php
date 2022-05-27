<?php

namespace App\Filament\Resources\LearningArtifactResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\LearningArtifactResource;
use Closure;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;

class CreateLearningArtifact extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = LearningArtifactResource::class;

    protected function getSteps(): array {
        return [
            Step::make('Informações')
                ->description('Definir nome, categoria e pontos de exeperiência')
                ->icon('heroicon-o-pencil')
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
                    ]),

            Step::make('Upload do arquivo ou conteúdo externo')
                ->description('Definir se é upload de arquivo ou conteúdo externo')
                ->icon('heroicon-o-collection')
                ->schema([
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
                    ]),

            Step::make('Informações extras')
                ->description('Capa e Descrição do Learning Artifact')
                ->icon('heroicon-o-photograph')
                ->schema([
                    FileUpload::make('cover_path')
                        ->rules(['required','image', 'max:1024'])
                        ->image()
                        ->placeholder('Cover Path')
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
                ])
            ];
    }
}
