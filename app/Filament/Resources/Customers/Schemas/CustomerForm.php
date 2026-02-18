<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Cliente')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->columnSpan(2)
                            ->default(true)
                            ->required(),
                        TextInput::make('name')
                            ->label('Nombre completo')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->required()
                            ->unique(table: 'customers', column: 'email', ignoreRecord: true)
                            ->validationMessages(['unique' => 'El correo electrónico ya está registrado.'])
                            ->email(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->required()
                            ->prefix('+56 ')
                            ->unique(table: 'customers', column: 'phone', ignoreRecord: true)
                            ->validationMessages(['unique' => 'El teléfono ya está registrado.'])
                            ->tel(),
                        TextInput::make('rut')
                            ->label('RUT o Razon Social')
                            ->unique(table: 'customers', column: 'rut', ignoreRecord: true)
                            ->validationMessages(['unique' => 'El RUT o Razon Social ya está registrado.'])
                            ->required(),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->required(),
                    ]),
            ]);
    }
}
