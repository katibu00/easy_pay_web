<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Combo;

class APIHomeController extends Controller
{

    public function getCombos()
    {
        // Replace 'product_column_name' with the actual name column in your products table
        $combos = Combo::select('id','title','description','sale_price','original_price','featured_image')->get();
    
        // You can customize the response format as needed
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
        ])->select('combos.id', 'title', 'description', 'original_price', 'sale_price', 'category_id', 'featured_image')
          ->find($id);
    
        if (!$combo) {
            return response()->json(['message' => 'Combo not found'], 404);
        }
    
        return response()->json(['combo' => $combo], 200);
    }
    
}
