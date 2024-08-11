<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'price',
    //     'amount',
    //     'slug',
    //     'photo',
    // ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}

