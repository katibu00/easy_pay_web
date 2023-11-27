<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Combo;
use App\Models\PickupCenter;
use App\Models\State;

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
                    ->with(['featuredImage' => function ($query) {
                        $query->select('id', 'image_path', 'product_id', 'is_featured');
                    }]);
            },
        ])->select('combos.id', 'title', 'long_description', 'combo_terms', 'sale_price', 'category_id', 'featured_image', 'price_30', 'price_60', 'price_90')
            ->find($id);
    
        if (!$combo) {
            return response()->json(['message' => 'Combo not found'], 404);
        }
    
        return response()->json(['combo' => $combo], 200);
    }
    
    

    public function fetchLocations()
    {
        $states = State::with('cities.pickupCenters')
        ->select(['id', 'name'])
        ->get();

        return response()->json(['states' => $states]);
       
    }


    public function getAllCategoriesWithCombos()
    {
        $categoriesWithCombos = Category::with('combos')->get();

        return response()->json($categoriesWithCombos, 200);
    }

    public function getCombosByCategory($category)
    {
        $combos = Combo::where('category_id', $category)->get();

        return response()->json($combos, 200);
    }

}
