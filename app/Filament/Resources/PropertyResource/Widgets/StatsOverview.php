<?php

namespace App\Filament\Resources\PropertyResource\Widgets;

use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $commercial_category_name = 'commercial';
        $residential_category_name = 'residential';
        $land_category_name = 'land';

        return [
            Card::make('Total Leased Properties', Property::where('is_leased', '=', '1')->count()),
            Card::make('Total Commercial Properties', DB::table('properties')
                ->join(
                    'categories', 'category_id', '=', 'categories.id'
                    )
                    ->when($commercial_category_name, function ($query, $commercial_category_name) {
                        $query->where('categories.category_name', $commercial_category_name);
                    })
                ->count()),
                Card::make('Total Residential Properties', DB::table('properties')
                ->join(
                    'categories', 'category_id', '=', 'categories.id'
                    )
                    ->when($residential_category_name, function ($query, $residential_category_name) {
                        $query->where('categories.category_name', $residential_category_name);
                    })
                ->count()),
                Card::make('Other Properties', DB::table('properties')
                ->join(
                    'categories', 'category_id', '=', 'categories.id'
                    )
                    ->when($land_category_name, function ($query, $land_category_name) {
                        $query->where('categories.category_name', $land_category_name);
                    })
                ->count()),
        ];
    }
}
