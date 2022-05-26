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
                ->description('Testando')
                ->schema([
                    TextInput::make('name')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Name')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('description')
                        ->rules(['nullable', 'max:255', 'string'])
                        ->placeholder('Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            Step::make('Cover')
                ->description('Testando')
                ->schema([
                    FileUpload::make('cover_path')
                        ->rules(['image', 'max:1024'])
                        ->image()
                        ->required()
                        ->placeholder('Cover Path')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            Step::make('Configs')
                ->description('Testando')
                ->schema([

                    TextInput::make('time_limit')
                        ->numeric()
                        ->minValue(0)
                        ->step(5)
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
