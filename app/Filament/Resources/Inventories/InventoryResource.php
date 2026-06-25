<?php

namespace App\Filament\Resources\Inventories;

use App\Filament\Resources\Inventories\Pages\CreateInventory;
use App\Filament\Resources\Inventories\Pages\EditInventory;
use App\Filament\Resources\Inventories\Pages\ListInventories;
use App\Filament\Resources\Inventories\Schemas\InventoryForm;
use App\Filament\Resources\Inventories\Tables\InventoriesTable;
use App\Models\Inventory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

     //UI
    protected static ?string $navigationLabel = 'Inventarios';
    protected static ?string $label = 'Inventario';
    protected static ?string $pluralLabel = 'Inventarios';
    protected static ?string $slug = 'inventarios';
    protected static string|UnitEnum|null $navigationGroup = 'Administración';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clipboard;

    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
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
            'index' => ListInventories::route('/'),
            //'create' => CreateInventory::route('/create'),
            //'edit' => EditInventory::route('/{record}/edit'),
        ];
    }
}
