<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function create()
    {
        $data['categories'] = Category::all();
        $data['locations'] = Location::all();
        return view('products.create', $data);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sale_price' => 'required|numeric',
            'original_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'quantity_in_stock' => 'required|integer',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:1048',

        ]);

        // Create a new product instance
        $product = new Product();
        $product->title = $request->input('title');
        $product->slug = Str::slug($request->input('name'));
        $product->description = $request->input('description');
        $product->sale_price = $request->input('sale_price');
        $product->original_price = $request->input('original_price');
        $product->category_id = $request->input('category_id');
        $product->location_id = $request->input('location_id');
        $product->quantity_in_stock = $request->input('quantity_in_stock');
        $product->save();

        // Handle image uploads


        if ($request->hasFile('images')) {
            $images = [];

            foreach ($request->file('images') as $index => $imageFile) {
                $filename = time() . '_' . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('uploads'), $filename);

                // Create a product image record
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image_path = $filename;
                $productImage->save(); // Save the product image first

                $images[] = $productImage;

                // Set the first image as featured
                if ($index === 0) {
                    $product->featured_image_id = $productImage->id;
                    $productImage->is_featured = true;
                } else {
                    $productImage->is_featured = false;
                }

                $productImage->save();
            }

            // Update the product with the featured_image_id
            $product->save();
        }





        $product->save();

        // Redirect back or to a success page
        return redirect()->route('products.create')->with('success', 'Product created successfully!');
    }


    public function index()
    {
        $products = Product::with('category', 'featuredImage')->get();
        
        return view('products.index', compact('products'));
    }
}
