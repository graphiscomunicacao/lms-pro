<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\{Forms\Components\BelongsToManyMultiSelect,
    Forms\Components\Card,
    Forms\Components\FileUpload,
    Tables,
    Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make(['default' => 0])
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

                    BelongsToSelect::make('role_id')
                        ->rules(['required', 'exists:roles,id'])
                        ->relationship('role', 'name')
                        ->searchable()
                        ->placeholder('Perfil')
                        ->label('Perfil')
                        ->required()
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    BelongsToSelect::make('job_id')
                        ->rules(['required', 'exists:jobs,id'])
                        ->relationship('job', 'name')
                        ->searchable()
                        ->placeholder('Cargo')
                        ->label('Cargo')
                        ->required()
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    BelongsToSelect::make('manager_id')
                        ->rules(['nullable', 'exists:users,id'])
                        ->relationship('manager', 'name')
                        ->searchable()
                        ->placeholder('Responsável')
                        ->label('Responsável')
                        ->required()
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    BelongsToSelect::make('group_id')
                        ->rules(['exists:groups,id'])
                        ->relationship('group', 'name')
                        ->searchable()
                        ->placeholder('Grupo')
                        ->label('Grupo')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
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

                    FileUpload::make('profile_photo_path')
                        ->rules(['image', 'max:2048'])
                        ->image()
                        ->placeholder('Foto de Perfil')
                        ->label('Foto de Perfil')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('password')
                        ->visibleOn(Pages\EditUser::Class)
                        ->password()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->placeholder('Insira aqui a nova senha')
                        ->label('Alterar Senha')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ])
                ->columns([
                    12
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Criado')
                        ->content(fn(?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Modificado')
                        ->content(fn(?User $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
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
                Tables\Columns\ImageColumn::make('profile_photo_path')
                    ->rounded()
                    ->label('Foto de Perfil'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('role.name')
                    ->label('Perfil')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('job.name')
                    ->label('Cargo')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('manager.name')
                    ->label('Responsável')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('group.name')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TagsColumn::make('teams.name')
                    ->label('Equipes')
                    ->searchable(),
            ])
            ->defaultSort('name')
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

                MultiSelectFilter::make('role_id')->relationship(
                    'role',
                    'name'
                )
                ->label('Perfis'),

                MultiSelectFilter::make('job_id')->relationship(
                    'job', 'name'
                )
                ->label('Cargos'),

                MultiSelectFilter::make('user_id')->relationship(
                    'manager',
                    'name'
                )
                ->label('Responsável'),

                MultiSelectFilter::make('group_id')->relationship(
                    'group',
                    'name'
                )
                ->label('Grupos'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
