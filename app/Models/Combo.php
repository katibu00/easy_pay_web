<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function products()
{
    return $this->belongsToMany(Product::class)->withPivot('quantity');
}

public function productsWithImages()
{
    return $this->belongsToMany(Product::class)
        ->withPivot('quantity')
        ->with(['productImages' => function ($query) {
            $query->select('product_id', 'image_path');
        }]);
}



}
