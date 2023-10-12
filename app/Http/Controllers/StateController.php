<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $states = State::all();
        return view('states.index', compact('states'));
    }

    public function create()
    {
        return view('states.create');
    }

    public function store(Request $request)
    {
        $state = new State();
        $state->name = $request->input('name');
        $state->save();

        return redirect()->route('states.index')->with('success', 'State created successfully!');;
    }

   

    public function edit($id)
    {
        $state = State::find($id);
        return view('states.edit', compact('state'));
    }

    public function update(Request $request, $id)
    {
        $state = State::find($id);
        $state->name = $request->input('name');
        // Additional fields can be updated here
        $state->save();

        return redirect()->route('states.index')->with('success', 'State updated successfully!');;
    }

    public function destroy($id)
    {
        $state = State::find($id);
        $state->delete();

        return redirect()->route('states.index')->with('success', 'State deleted successfully!');;
    }
}
