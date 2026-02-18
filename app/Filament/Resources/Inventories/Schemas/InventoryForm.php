<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Registro de Inventario')
                    ->columns(2)
                    ->schema([
                        Select::make('product_id')
                            ->label('Productos')
                            ->searchable()
                            ->preload()
                            ->relationship('product', 'name')
                            ->required(),
                        Select::make('warehouse_id')
                            ->label('Almacenes')
                            ->searchable()
                            ->preload()
                            ->relationship('warehouse', 'name')
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Cantidad de Stock')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
            ]);
    }
}
