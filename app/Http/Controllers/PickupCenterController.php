<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PickupCenter;
use App\Models\City;

class PickupCenterController extends Controller
{
    public function index()
    {
        $pickupCenters = PickupCenter::with('city')->get();
        $cities = City::all();
        return view('pickup-centers.index', compact('pickupCenters','cities'));
    }

    public function create()
    {
        $cities = City::all();

        return view('pickup-centers.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
        ]);

        PickupCenter::create($request->all());

        return redirect()->route('pickup-centers.index')->with('success', 'Pickup Center created successfully.');
    }

    public function show(PickupCenter $pickupCenter)
    {
        return view('pickup-centers.show', compact('pickupCenter'));
    }

    public function edit(PickupCenter $pickupCenter)
    {
        $cities = City::all();

        return view('pickup-centers.edit', compact('pickupCenter', 'cities'));
    }

    public function update(Request $request, PickupCenter $pickupCenter)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
        ]);

        $pickupCenter->update($request->all());

        return redirect()->route('pickup-centers.index')->with('success', 'Pickup Center updated successfully.');
    }

    public function destroy(PickupCenter $pickupCenter)
    {
        $pickupCenter->delete();

        return redirect()->route('pickup-centers.index')->with('success', 'Pickup Center deleted successfully.');
    }
}
