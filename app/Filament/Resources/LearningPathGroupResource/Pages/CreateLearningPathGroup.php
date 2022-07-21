<?php

namespace App\Filament\Resources\LearningPathGroupResource\Pages;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\LearningPathGroupResource;

class CreateLearningPathGroup extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = LearningPathGroupResource::class;

    protected function getSteps(): array {
        return [
            Step::make('Informações Gerais')
                ->description('Insira as informações gerais sobre o Agrupament ode Trilhas')
                ->icon('heroicon-o-adjustments')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Nome')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('description')
                        ->label('Descrição')
                        ->rules(['nullable', 'max:255', 'string'])
                        ->placeholder('Descrição')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('cover_path')
                        ->label('Capa')
                        ->required()
                        ->rules(['image', 'max:1024'])
                        ->image()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    MultiSelect::make('categories')
                        ->label('Categorias')
                        ->relationship('categories', 'name')
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
                        ->minDate(now())
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
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('tries')
                        ->rules(['required', 'numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Máximo de Tentativas')
                        ->label('Máximo de Tentativas (0 = ilimitado)')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('approval_goal')
                        ->rules(['required', 'numeric'])
                        ->numeric()
                        ->placeholder('Meta de Aprovação')
                        ->label('Meta de Aprovação (em %)')
                        ->maxValue('100')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ])
        ];
    }
}
