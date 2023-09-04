<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combo;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;

class ComboController extends Controller
{
    public function create()
    {
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        $data['locations'] = Location::all();
        return view('combos.create', $data);
    }





    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Assuming you have a "categories" table
            'location_id' => 'required|exists:locations,id', // Assuming you have a "locations" table
            'featured_image' => 'image|mimes:jpeg,png,jpg|max:2048', // Validate the featured image
            'product_id' => 'array', // Assuming product_id is an array
            'product_id.*' => 'exists:products,id', // Validate each product_id
            'quantity' => 'array', // Assuming quantity is an array
            'quantity.*' => 'numeric|min:1', // Validate each quantity
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        } else {
            // Set a default image if no featured image is uploaded
            $imageName = 'no-image.jpg';
        }

        // Create a new Combo model instance
        $combo = new Combo();
        $combo->title = $request->input('title');
        $combo->description = $request->input('description');
        $combo->original_price = $request->input('original_price');
        $combo->sale_price = $request->input('sale_price');
        $combo->category_id = $request->input('category_id');
        $combo->location_id = $request->input('location_id');
        $combo->featured_image = $imageName;
        $combo->save();

        // Attach products and quantities to the combo
        for ($i = 0; $i < count($request->input('product_id')); $i++) {
            $combo->products()->attach($request->input('product_id')[$i], ['quantity' => $request->input('quantity')[$i]]);
        }
        

        // Redirect to a success page or return a response
        return redirect()->route('combos.create')->with('success', 'Combo created successfully');
    }

    public function index()
    {
        $combos = Combo::all();

        return view('combos.index', compact('combos'));
    }
    

}
