<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Product;
use App\Models\Inventory;

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
                            ->required()
                            ->live(),
                        Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->preload()
                            ->placeholder('Seleccione un cliente')
                            ->required()
                            ->live(),
                        TextInput::make('note')
                            ->label('Notas')
                            ->placeholder('Ingrese notas adicionales')
                            ->columnSpanFull(),
                    ]),

                Section::make('Carrito de compras')
                    ->hidden(
                        function (Get $get): bool {
                            $isVisible = empty($get('customer_id')) && empty($get('warehouse_id'));
                            return $isVisible;
                        }
                    )
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
                                    ->required()
                                    ->live()
                                    ->options(function (Get $get): array{
                                        $warehouseId = $get('../../warehouse_id');
                                        $products = Product::query()
                                            ->whereHas('inventories', fn ($q) =>$q->where('warehouse_id', $warehouseId))
                                            ->pluck('name', 'id')
                                            ->toArray();
                                        return $products;
                                    }),

                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->minValue(1)
                                    ->live()
                                    ->placeholder('Ingrese la cantidad')
                                    ->rules(function (Get $get){
                                        $productId = $get('product_id');
                                        $warehouseId = $get('../../warehouse_id');
                                        $stock = Inventory::where("product_id",$productId)
                                            ->where("warehouse_id", $warehouseId)
                                            ->value('quantity') ?? 0;
                                        return "max:$stock";
                                    })
                                    ->validationMessages([
                                        'max' => "No hay stock suficiente, lo sentimos",
                                        'required' => "La cantidad es requerida",
                                    ])
                                    ->required()
                                    ->helperText(function (Get $get){
                                        $productId = $get('product_id');
                                        $warehouseId = $get('../../warehouse_id');
                                        $inventory = Inventory::where('product_id', $productId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->value('quantity') ?? 0;
                                        return "Stock Disponible:{$inventory}";
                                    })
                                    ->afterStateUpdated(function (Get $get, Set $set,$state){
                                        $productId = $get("product_id");
                                        $quantity = $get("quantity");
                                        $product = Product::find($productId);
                                        $sub_Total = $quantity * ($product?->price ?? 0);
                                        $set("subtotal", $sub_Total);
                                        return $sub_Total;
                                    }),

                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->live()
                                    ->disabled()
                                    ->dehydrated()
                                    ->minValue(0)
                                    ->placeholder('Subtotal del producto')
                                    ->required(),
                                ])
                            ->afterStateUpdated(function (Get $get, Set $set, $state){
                                $total = 0;
                                foreach ($state as $item) {
                                    $productId = $item["product_id"];
                                    $quantity = $item["quantity"] ?? 0;
                                    $product = Product::find($productId);
                                    $total += (float) $quantity * (float)($product?->price ?? 0);
                                    $set("total", $total);
                                }
                            }),
                    ]),

                Section::make("Resumen de la Orden")
                    ->hidden(
                            function (Get $get): bool {
                                $isVisible = empty($get('customer_id')) && empty($get('warehouse_id'));
                                return $isVisible;
                            }
                        )
                    ->schema([
                            TextInput::make('total')
                                ->label('Total')
                                ->numeric()
                                ->live()
                                ->disabled()
                                ->dehydrated()
                                ->minValue(0)
                                ->placeholder('Total de la orden')
                                ->required(),
                    ]),
            ]);
    }
}