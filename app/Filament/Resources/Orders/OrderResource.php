<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    // UI
    protected static ?string $navigationLabel = 'Ventas';

    protected static ?string $label = 'Venta';

    protected static ?string $pluralLabel = 'Ventas';

    protected static ?string $slug = 'ventas';

    protected static string|UnitEnum|null $navigationGroup = 'CRM';

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-currency-dollar";

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            //'create' => CreateOrder::route('/create'),
            //'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
