<?php

namespace App\Filament\Resources\LearningPathResource\Pages;

use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\LearningPathResource;

class CreateLearningPath extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = LearningPathResource::class;

    protected function getSteps(): array {
        return [
            Step::make('Informações Gerais')
                ->description('Insira as informações gerais sobre a Trilha de Aprendizado')
                ->icon('heroicon-o-adjustments')
                ->schema([
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

                    TextInput::make('experience_amount')
                        ->rules(['required'])
                        ->label('Experiência Concedida')
                        ->numeric()
                        ->minValue(0)
                        ->required()
                        ->placeholder('Pontos')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('cover_path')
                        ->rules(['required', 'image', 'max:1024'])
                        ->image()
                        ->label('Capa')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),

            Step::make('Disponibilidade')
                ->description('Defina as configurações relacionadas ao tempo de disponibilidade')
                ->icon('heroicon-o-calendar')
                ->schema([
                    DateTimePicker::make('start_time')
                        ->rules(['nullable', 'date'])
                        ->placeholder('Data Inicial')
                        ->label('Data Inicial')
                        ->withoutSeconds()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DateTimePicker::make('end_time')
                        ->rules(['nullable', 'date'])
                        ->placeholder('Data Final')
                        ->label('Data Final')
                        ->withoutSeconds()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('availability_time')
                        ->rules(['nullable', 'numeric'])
                        ->numeric()
                        ->placeholder('Disponível por (dias)')
                        ->label('Disponível por (dias)')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),

            Step::make('Configurações de Aprovação')
                ->description('Defina as configurações relacionadas à Nota e quantidade de Tentativas')
                ->icon('heroicon-o-academic-cap')
                ->schema([
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
                        ->label('Máximo de Tentativas')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('approval_goal')
                        ->rules(['nullable', 'numeric'])
                        ->numeric()
                        ->placeholder('Meta de Aprovação')
                        ->label('Meta de Aprovação (em %)')
                        ->maxValue('100')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    BelongsToSelect::make('certificate_id')
                        ->rules(['required', 'exists:certificates,id'])
                        ->relationship('certificate', 'name')
                        ->searchable()
                        ->required()
                        ->placeholder('Certificado')
                        ->label('Certificado')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                ])
                ->columns(12),
        ];
    }
}
