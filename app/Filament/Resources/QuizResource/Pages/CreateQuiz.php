<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;


class CreateQuiz extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = QuizResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Quiz')
                ->description('Nome e Descrição')
                ->icon('heroicon-o-pencil')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Nome')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('description')
                        ->label('Descrição')
                        ->rules(['nullable', 'max:255', 'string'])
                        ->placeholder('Descrição breve')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            Step::make('Capa')
                ->description('Capa utilizada para o quiz')
                ->icon('heroicon-o-photograph')
                ->schema([
                    FileUpload::make('cover_path')
                        ->label('Capa')
                        ->rules(['image', 'max:1024'])
                        ->image()
                        ->required()
                        ->placeholder('Selecione uma imagem')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            Step::make('Detalhes')
                ->description('Configurações Adicionais')
                ->icon('heroicon-o-cog')
                ->schema([

                    TextInput::make('time_limit')
                        ->numeric()
                        ->minValue(0)
                        ->step(5)
                        ->default(10)
                        ->placeholder('Minutos')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('experience_amount')
                        ->numeric()
                        ->minValue(0)
                        ->step(10)
                        ->default(10)
                        ->placeholder('Experience')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                ])
        ];
    }
}
