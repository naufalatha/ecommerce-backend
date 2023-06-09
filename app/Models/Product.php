<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'categories_id',
        'tags',
    ];

    public function galleries()
    {
        return $this->hasMany(ProductPhoto::class, 'products_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'categories_id', 'id');
    }
}
