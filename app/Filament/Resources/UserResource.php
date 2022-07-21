<?php

namespace App\Filament\Resources;

use App\Models\Team;
use App\Models\User;
use Filament\{Facades\Filament,
    Forms\Components\Card,
    Forms\Components\MultiSelect,
    Forms\Components\Select,
    Tables,
    Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Usuário';

    protected static ?string $navigationGroup = "Gerenciar usuários";

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

                    Select::make('role_id')
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

                    Select::make('job_id')
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

                    Select::make('manager_id')
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

                    Select::make('group_id')
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

                    MultiSelect::make('teams')
                        ->placeholder('Equipes')
                        ->label('Equipes')
                        ->relationship('teams', 'name')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ])
                ->columns(12)
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
                    ->label('Avatar')
                    ->extraHeaderAttributes(['style' => 'width:10px']),
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
                Tables\Columns\TextColumn::make('manager.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Responsável')
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('role.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Perfil')
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('job.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Cargo')
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('group.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Grupo')
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TagsColumn::make('teams.name')
                    ->toggleable()
                    ->label('Equipes')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date('d/m/y h:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ultima atualização')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date('d/m/y h:i'),
            ])
            ->defaultSort('name')
            ->actions([
                Tables\Actions\Action::make('changePassword')
                    ->label('Alterar Senha')
                    ->form([
                        TextInput::make('new_password')
                            ->password()
                            ->label('Nova Senha')
                            ->required()
                            ->rule(Password::default()),
                        TextInput::make('new_password_confirmation')
                            ->password()
                            ->label('Repita a Nova Senha')
                            ->required()
                            ->same('new_password')
                            ->rule(Password::default()),
                    ])
                    ->icon('heroicon-o-lock-closed')
                    ->action(function(User $record, array $data) {
                        $record->update([
                            'password' => Hash::make($data['new_password'])
                        ]);
                        Filament::notify('success', 'Senha alterada com sucesso!');
                    })
            ])
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

                SelectFilter::make('user_id')
                    ->relationship('manager','name')
                    ->label('Responsável'),

                SelectFilter::make('role_id')
                    ->relationship('role','name')
                    ->label('Perfis'),

                SelectFilter::make('job_id')
                    ->relationship('job', 'name')
                    ->label('Cargos'),

                SelectFilter::make('group_id')
                    ->relationship('group','name')
                    ->label('Grupos'),

                SelectFilter::make('team_id')
                    ->relationship('teams', 'name')
                    ->label('Equipes'),
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

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
