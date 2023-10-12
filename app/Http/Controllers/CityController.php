<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('state')->get();
        $states = State::all();
        return view('cities.index', compact('cities','states'));
    }

    public function create()
    {
        $states = State::all();
        return view('cities.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required|exists:states,id',
        ]);

        City::create([
            'name' => $request->input('name'),
            'state_id' => $request->input('state_id'),
        ]);

        return redirect()->route('cities.index')->with('success', 'City created successfully');
    }

    public function show($id)
    {
        $city = City::with('state')->find($id);
        return view('cities.show', compact('city'));
    }

    public function edit($id)
    {
        $city = City::find($id);
        $states = State::all();
        return view('cities.edit', compact('city', 'states'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required|exists:states,id',
        ]);

        $city = City::find($id);
        $city->name = $request->input('name');
        $city->state_id = $request->input('state_id');
        $city->save();

        return redirect()->route('cities.index')->with('success', 'City updated successfully');
    }

    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();

        return redirect()->route('cities.index')->with('success', 'City deleted successfully');
    }
}
