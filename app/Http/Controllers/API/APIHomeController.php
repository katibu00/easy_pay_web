<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Combo;

class APIHomeController extends Controller
{

    public function getCombos()
    {
        $combos = Combo::select('id','title','short_description','sale_price','featured_image')->get();
    
        $response = [
            'success' => true,
            'message' => 'Combos with products fetched successfully',
            'combos' => $combos,
        ];
    
        return response()->json($response, 200);
    }
    


    public function showCombo($id)
    {
        $combo = Combo::with([
            'products' => function ($query) {
                $query->select('products.id', 'title', 'description', 'featured_image_id')
                    ->with('featuredImage:image_path,product_id,is_featured');
            },
        ])->select('combos.id', 'title', 'long_description', 'sale_price', 'category_id', 'featured_image')
          ->find($id);
    
        if (!$combo) {
            return response()->json(['message' => 'Combo not found'], 404);
        }
    
        return response()->json(['combo' => $combo], 200);
    }
    
}
