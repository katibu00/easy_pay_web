<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIOrderController extends Controller
{
 
    public function placeOrder(Request $request)
    {

        $request->validate([
            'productId' => 'required|exists:combos,id',
            'paymentMode' => 'required|string',
            'paymentDuration' => 'required|string',
            'addressState' => 'required|string',
            'addressCity' => 'required|string',
        ]);

        // $order = new Order();
        // $order->order_number = uniqid(); 
        // $order->combo_id = $request->input('setProductId');
        // $order->user_id = auth()->user()->id;
        // $order->status = 'pending';
        // $order->state = $request->input('setAddressState');
        // $order->city = $request->input('setAddressCity');

        // $order->save();

        // return response()->json(['message' => 'Order placed successfully'], 201);
        $userId = Auth::id();

        $message = 'Order placed successfully. address type: ' . $request->addressType;

        return response()->json(['message' => $message], 201);
    
    }
}
