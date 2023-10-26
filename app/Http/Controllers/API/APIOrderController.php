<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIOrderController extends Controller
{
 
    public function placeOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'productId' => 'required|exists:combos,id',
            'paymentMode' => 'required|string',
            'paymentDuration' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'streetAddress' => 'nullable|string',
            'pickupLocation' => 'nullable|string',
            'addressType' => 'nullable|string',
            'town' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = Auth::id();
        $productId = $request->productId;
        $existingOrder = Order::where('user_id', $userId)->where('combo_id', $productId)->first();

        if ($existingOrder) {
            $message = 'You have already placed an order for this product.';
            return response()->json(['message' => $message], 400);
        }

        $order = new Order();
        $order->order_number = uniqid(); 
        $order->combo_id = $request->productId;
        $order->user_id = $userId;
        $order->status = 'pending';
        $order->payment_mode = $request->paymentMode;
        $order->payment_duration = $request->paymentDuration;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->address_type = $request->addressType;
        $order->pickup_location = $request->pickupLocation;
        $order->town = $request->town;
        $order->street_address = $request->streetAddress;
        $order->landmark = $request->landmark;

        $order->save();
       
        $message = 'Order placed successfully.';

        return response()->json(['message' => $message], 201);
    
    }
}
