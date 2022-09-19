<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

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
