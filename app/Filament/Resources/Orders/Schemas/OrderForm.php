<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informacion de salida')
                    ->columns(2)
                    ->schema([
                        Select::make('warehouse_id')
                            ->label('Almacén')
                            ->relationship('warehouse', 'name')
                            ->preload()
                            ->placeholder('Seleccione un almacén')
                            ->live()
                            ->required(),
                        Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->preload()
                            ->placeholder('Seleccione un cliente')
                            ->live()
                            ->required(),
                        TextInput::make('note')
                            ->label('Notas')
                            ->placeholder('Ingrese notas adicionales')
                            ->columnSpanFull(),
                    ]),

                Section::make('Carrito de compras')
                    // ->hidden()
                    ->schema([
                        Repeater::make('orderProducts')
                            ->relationship()
                            ->columns(3)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Producto')
                                    ->relationship('product', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->placeholder('Seleccione un producto')
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->minValue(1)
                                    ->placeholder('Ingrese la cantidad')
                                    ->required(),
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->disabled()
                                    ->placeholder('Subtotal del producto')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
