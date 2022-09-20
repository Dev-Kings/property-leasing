<?php

namespace App\Filament\Resources\LeaseResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    protected static ?string $recordTitleAttribute = 'property_name';

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
                        ->visible(fn (Component $livewire): bool => $livewire instanceof EditProperty)
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
                Tables\Columns\TextColumn::make('locations.location_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->money('kes')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('properties'),
                Tables\Columns\TextColumn::make('description')->limit('50')->searchable(),
                Tables\Columns\BooleanColumn::make('is_leased')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
