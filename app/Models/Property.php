<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'property_name',
        'price',
        'description',
        'is_leased'
    ];

    protected $casts = [
        'is_leased' => 'boolean',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
