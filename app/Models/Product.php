<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // public function featuredImage()
    // {
    //     return $this->hasOne(ProductImage::class)->where('is_featured', true);
    // }
    

    public function combos()
    {
        return $this->belongsToMany(Combo::class)->withPivot('quantity');
    }

    // Product.php

    public function featuredImage()
    {
        return $this->belongsTo(ProductImage::class, 'featured_image_id');
    }

    

}
