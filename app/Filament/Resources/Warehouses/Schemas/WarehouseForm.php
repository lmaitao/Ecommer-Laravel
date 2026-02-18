<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WarehouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Almacén')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Nombre del Almacén')
                            ->required(),
                        TextInput::make('location')
                            ->label('Ubicación')
                            ->placeholder('Ubicación del Almacén')
                            ->required(),
                    ]),
            ]);
    }
}
