<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use App\Filament\Resources\Categories\Schemas\CategoryForm;


class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informacion del producto')
                    ->columns(3)
                    ->components([
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->columnSpan(3)
                            ->default(true)
                            ->required(),
                         TextInput::make('code')
                            ->label('Código del producto')
                            ->placeholder('Ej: SUS-001')
                            ->required(),
                        TextInput::make('name')
                            ->label('Nombre del producto')
                            ->required(),
                        TextInput::make('summary')
                            ->label('Resumen')
                            ->required(),
                        TextInput::make('price')
                            ->label('Precio')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('CLP $')
                            ->required(),
                        Select::make('category_id')
                            ->label('Categoría')
                            ->required()
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm(CategoryForm::create())
                    ]),

                Section::make('Imagen del producto')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(1024)
                            ->acceptedFileTypes(['image/*'])
                            ->required()
                            ->visibility('public'),
                    ]),

                Section::make('Descripción del producto')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Descripción')
                            ->required(),
                    ]),
            ]);
    }
}
