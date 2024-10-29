<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function create()
    {
        $data['categories'] = Category::all();
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
        $product->quantity_in_stock = $request->input('quantity_in_stock');
        $product->save();

        // Handle image uploads


        if ($request->hasFile('images')) {
            $images = [];

            foreach ($request->file('images') as $index => $imageFile) {
                $filename = time() . '_' . $index . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads'), $filename);

                // Create a product image record
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image_path = $filename;
                $productImage->save(); // Save the product image first

                $images[] = $productImage;

                // Set the first image as featured
                if (count($images) > 0) {
                    $product->featured_image_id = $images[0]->id;
                    $images[0]->is_featured = true;
                }

                $productImage->save();
            }

            // Update the product with the featured_image_id
            $product->save();
        }





        $product->save();

        // Redirect back or to a success page
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    public function index()
    {
        $products = Product::with('category', 'featuredImage')->get();
        
        return view('products.index', compact('products'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sale_price' => 'required|numeric',
            'original_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'quantity_in_stock' => 'required|integer',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:1048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update product attributes
        $product->title = $request->input('title');
        $product->slug = Str::slug($request->input('name'));
        $product->description = $request->input('description');
        $product->sale_price = $request->input('sale_price');
        $product->original_price = $request->input('original_price');
        $product->category_id = $request->input('category_id');
        $product->quantity_in_stock = $request->input('quantity_in_stock');

        // Handle image uploads
        if ($request->hasFile('images')) {
            // Delete existing images
            foreach ($product->images as $image) {
                Storage::delete('uploads/' . $image->image_path);
                $image->delete();
            }

            // Upload new images
            foreach ($request->file('images') as $index => $imageFile) {
                $filename = time() . '_' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads'), $filename);

                // Create a product image record
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image_path = $filename;
                $productImage->save();

                // Set the first uploaded image as featured
                if ($index === 0) {
                    $product->featured_image_id = $productImage->id;
                }
            }
        }

        // Save the updated product
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete associated images
        foreach ($product->images as $image) {
            // Log image information

            // Delete image file from storage
            Storage::delete('uploads/' . $image->image_path);

            // Delete image record from the database
            $image->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

}
