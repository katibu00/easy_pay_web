<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;

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

    // public function userOrderedCombos(Request $request)
    // {
    //     $userId = Auth::id();

    //     $orders = Order::select('id', 'combo_id', 'payment_mode', 'payment_duration')->where('user_id', $userId)
    //         ->with(['combo:id,title,featured_image'])
    //         ->get();

    //     return response()->json(['orders' => $orders], 200);
    // }


    // public function getOrderDetails($comboId)
    // {
    //     $order = Order::where('id', $comboId)->first();

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

    //     $combo = Combo::find($order->combo_id);

    //     $data = [
    //         'sale_price' => $combo->sale_price, 
    //     ];

    //     return response()->json($data);
    // }




public function fetchUserCombos()
{
    // Get the authenticated user
    $user = Auth::user();

    // Fetch all orders for the user with related combo information
    $userOrders = Order::with(['combo', 'payments'])
        ->where('user_id', $user->id)
        ->get();

    // Transform the data for display
    $combosData = $userOrders->map(function ($order) {
        $combo = $order->combo;

        // Get the last payment for the order
        $lastPayment = $order->payments->last();

        // Calculate next payment date based on the last payment or order date
        $nextPaymentDate = $lastPayment ? $lastPayment->created_at->addDays($order->payment_mode === 'weekly' ? 7 : 1)
            : $order->created_at;

        // Calculate amount to pay and remaining balance
        $amountToPay = $order->payment_duration === '30_day' ? $combo->price_30
            : ($order->payment_duration === '60_day' ? $combo->price_60
                : ($order->payment_duration === '90_day' ? $combo->price_90 : $combo->price_125));

        $remainingBalance = $amountToPay - $order->total_paid;

        return [
            'combo_title' => $combo->title,
            'next_payment_date' => $nextPaymentDate,
            'amount_to_pay' => $amountToPay,
            'remaining_balance' => $remainingBalance,
        ];
    });

    return response()->json(['combos' => $combosData]);
}




}
