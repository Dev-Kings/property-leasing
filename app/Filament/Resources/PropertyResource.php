<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use App\Models\Property;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PropertyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\PropertyResource\RelationManagers;
use Filament\Forms\Components\Textarea;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('category_id')
                        ->relationship('category', 'category_name'),
                    Select::make('lease_id')
                        ->relationship('lease', 'lease_type'),
                    Forms\Components\TextInput::make('property_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('price')
                        ->required(),
                    SpatieMediaLibraryFileUpload::make('thumbnail')->collection('properties'),
                    Textarea::make('description')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('is_leased')
                        ->visible(fn (Component $livewire): bool => $livewire instanceof Pages\EditProperty)
                        ->onColor('success')
                        ->offColor('danger'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.category_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lease.lease_type')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('property_name')->searchable()->sortable(),
                //Tables\Columns\TextColumn::make('price')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->money('kes')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('properties'),
                Tables\Columns\TextColumn::make('description')->limit('50')->searchable(),
                Tables\Columns\BooleanColumn::make('is_leased')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
