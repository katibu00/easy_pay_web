<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $state = new Category();
        $state->name = $request->input('name');
        $state->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');;
    }

   

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->input('name');
        // Additional fields can be updated here
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');;
    }

    public function destroy($id)
    {
        $state = Category::find($id);
        $state->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');;
    }
}
