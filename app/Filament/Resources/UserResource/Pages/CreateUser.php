<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = UserResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Dados Pessoais')
                ->description('Insira os dados pessoais do novo usuário')
                ->icon('heroicon-o-identification')
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

                    TextInput::make('email')
                        ->rules(['required', 'email'])
                        ->unique(ignorable: fn (?Model $record): ?Model => $record)
                        ->email()
                        ->placeholder('Email')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('manager_id')
                        ->rules(['nullable', 'exists:users,id'])
                        ->relationship('manager', 'name')
                        ->searchable()
                        ->placeholder('Responsável')
                        ->label('Responsável')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            Step::make('Dados Corporativos')
                ->description('Insira os dados relacionados à corporação')
                ->icon('heroicon-o-briefcase')
                ->schema([
                    BelongsToSelect::make('role_id')
                        ->rules(['required', 'exists:roles,id'])
                        ->relationship('role', 'name')
                        ->searchable()
                        ->placeholder('Perfil')
                        ->label('Perfil')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('job_id')
                        ->rules(['required', 'exists:jobs,id'])
                        ->relationship('job', 'name')
                        ->searchable()
                        ->placeholder('Cargo')
                        ->label('Cargo')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToManyMultiSelect::make('teams')
                        ->placeholder('Equipes')
                        ->label('Equipes')
                        ->relationship('teams', 'name')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('group_id')
                        ->rules(['exists:groups,id'])
                        ->relationship('group', 'name')
                        ->searchable()
                        ->placeholder('Grupo')
                        ->label('Grupo (opcional)')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
        ];
    }
}
