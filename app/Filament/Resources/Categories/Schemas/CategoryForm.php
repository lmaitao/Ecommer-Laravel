<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Detalles de la Categoria')
                    ->columns(2)
                    ->schema(static::create()),
            ]);
    }

    public static function create()
    {
        return [
             TextInput::make('name')
                ->label('Nombre')
                ->placeholder('Nombre de la Categoria')
                ->required(),
            TextInput::make('summary')
                ->label('Resumen')
                 ->placeholder('Resumen de la Categoria')
                ->required(),
        ];
    }
}
