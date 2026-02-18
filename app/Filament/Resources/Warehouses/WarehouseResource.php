<?php

namespace App\Filament\Resources\Warehouses;

use App\Filament\Resources\Warehouses\Pages\CreateWarehouse;
use App\Filament\Resources\Warehouses\Pages\EditWarehouse;
use App\Filament\Resources\Warehouses\Pages\ListWarehouses;
use App\Filament\Resources\Warehouses\Schemas\WarehouseForm;
use App\Filament\Resources\Warehouses\Tables\WarehousesTable;
use App\Models\Warehouse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

     //UI
    protected static ?string $navigationLabel = 'Almacenes';
    protected static ?string $label = 'Almacén';
    protected static ?string $pluralLabel = 'Almacenes';
    protected static ?string $slug = 'almacenes';
    protected static string|UnitEnum|null $navigationGroup = 'Administración';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    public static function form(Schema $schema): Schema
    {
        return WarehouseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarehousesTable::configure($table);
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
            'index' => ListWarehouses::route('/'),
            //'create' => CreateWarehouse::route('/create'),
            //'edit' => EditWarehouse::route('/{record}/edit'),
        ];
    }
}
