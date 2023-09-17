<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Combo;
use App\Models\Product;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function create()
    {
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        return view('combos.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'combo_terms' => 'nullable|string',
            'price_30' => 'nullable|numeric',
            'price_60' => 'nullable|numeric',
            'price_90' => 'nullable|numeric',
            'price_125' => 'nullable|numeric',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => 'array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'array',
            'quantity.*' => 'numeric|min:1',
        ]);

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        } else {

            $imageName = 'no-image.jpg';
        }

        $combo = new Combo();
        $combo->title = $request->input('title');
        $combo->short_description = $request->input('short_description');
        $combo->long_description = $request->input('long_description');
        $combo->combo_terms = $request->input('combo_terms');
        $combo->original_price = $request->input('original_price');
        $combo->sale_price = $request->input('sale_price');
        $combo->category_id = $request->input('category_id');
        $combo->price_30 = $request->input('price_30');
        $combo->price_60 = $request->input('price_60');
        $combo->price_90 = $request->input('price_90');
        $combo->price_125 = $request->input('price_125');
        $combo->featured_image = $imageName;
        $combo->save();

        for ($i = 0; $i < count($request->input('product_id')); $i++) {
            $combo->products()->attach($request->input('product_id')[$i], ['quantity' => $request->input('quantity')[$i]]);
        }

        return redirect()->route('combos.create')->with('success', 'Combo created successfully');
    }

    public function index()
    {
        $combos = Combo::all();

        return view('combos.index', compact('combos'));
    }

    public function show(Combo $combo)
    {
        return view('combos.show', compact('combo'));
    }

    public function edit(Combo $combo)
    {
        $categories = Category::all();
        $products = Product::all();
        return view('combos.edit', compact('combo', 'categories', 'products'));
    }

    public function update(Request $request, Combo $combo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'combo_terms' => 'nullable|string',
            'price_30' => 'nullable|numeric',
            'price_60' => 'nullable|numeric',
            'price_90' => 'nullable|numeric',
            'price_125' => 'nullable|numeric',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => 'array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'array',
            'quantity.*' => 'numeric|min:1',
        ]);

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            if ($combo->featured_image !== 'no-image.jpg') {
                unlink(public_path('uploads/' . $combo->featured_image));
            }
            $combo->featured_image = $imageName;
        }

        $combo->title = $request->input('title');
        $combo->short_description = $request->input('short_description');
        $combo->long_description = $request->input('long_description');
        $combo->combo_terms = $request->input('combo_terms');
        $combo->original_price = $request->input('original_price');
        $combo->sale_price = $request->input('sale_price');
        $combo->category_id = $request->input('category_id');
        $combo->price_30 = $request->input('price_30');
        $combo->price_60 = $request->input('price_60');
        $combo->price_90 = $request->input('price_90');
        $combo->price_125 = $request->input('price_125');
        $combo->save();

        $productsData = [];
        for ($i = 0; $i < count($request->input('product_id')); $i++) {
            $productsData[$request->input('product_id')[$i]] = ['quantity' => $request->input('quantity')[$i]];
        }
        $combo->products()->sync($productsData);

        return redirect()->route('combos.edit', ['combo' => $combo->id])->with('success', 'Combo updated successfully');
    }

    public function destroy(Combo $combo)
    {
        $combo->products()->detach();

        if ($combo->featured_image !== 'no-image.jpg') {
            unlink(public_path('uploads/' . $combo->featured_image));
        }

        $combo->delete();

        return redirect()->route('combos.index')->with('success', 'Combo deleted successfully');
    }

}
