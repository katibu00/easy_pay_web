<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Combo;
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


    public function fetchUserCombos()
    {
        $user = Auth::user();
    
        $userOrders = Order::with(['combo', 'payments'])
            ->where('user_id', $user->id)
            ->get();
    
        $combosData = $userOrders->map(function ($order) {
            $combo = $order->combo;
    
            $lastPayment = $order->payments->last();
    
            $nextPaymentDate = $lastPayment ? $lastPayment->created_at->addDays($order->payment_mode === 'weekly' ? 7 : 1)
                : $order->created_at;
    
            $amountToPay = $order->payment_duration === '30 days' ? $combo->price_30
                : ($order->payment_duration === '60 days' ? $combo->price_60
                    : ($order->payment_duration === '90 days' ? $combo->price_90 : $combo->price_125));
    
            // Calculate the total amount paid for the combo
            $totalPaid = $order->payments->sum('amount');
    
            // Subtract the total amount paid from the combo sale price
            $remainingBalance = $combo->sale_price - $totalPaid;
    
            return [
                'order_id' => $order->id,
                'combo_title' => $combo->title,
                'next_payment_date' => $nextPaymentDate,
                'amount_to_pay' => $amountToPay,
                'remaining_balance' => $remainingBalance,
            ];
        });
    
        return response()->json(['combos' => $combosData]);
    }



    public function getOrderDetails($orderId)
    {
        $order = Order::with(['combo', 'payments'])
            ->find($orderId);
    
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    
        $combo = $order->combo;
        $payments = $order->payments;
    
        // Calculate progress
        $totalAmountPaid = $payments->sum('amount');
        $progress = ($totalAmountPaid / $combo->sale_price) * 100;
    
        // Calculate next payment date based on the last payment or order date
        $lastPayment = $payments->last();
        $nextPaymentDate = $lastPayment ? $lastPayment->created_at->addDays($order->payment_mode === 'weekly' ? 7 : 1)
            : $order->created_at;
    
        // Calculate amount to pay
        $amountToPay = $order->payment_duration === '30 days' ? $combo->price_30
                    : ($order->payment_duration === '60 days' ? $combo->price_60
                        : ($order->payment_duration === '90 days' ? $combo->price_90 : $combo->price_125));
    
        // Calculate remaining balance
        $remainingBalance = $combo->sale_price - $totalAmountPaid;
    
        // Fetch recent payments (let's say the last 5 payments)
        $recentPayments = $payments->sortByDesc('created_at')->take(5);
    
        // Prepare payment history for the response
        $paymentHistory = $recentPayments->map(function ($payment) {
            return [
                'payment_date' => $payment->created_at,
                'amount_paid' => $payment->amount,
                'date_paid' => $payment->created_at->format('Y-m-d'), // Adjust the date format as needed
            ];
        });
    
        return response()->json([
            'progress' => $progress,
            'combo_title' => $combo->title,
            'next_payment_date' => $nextPaymentDate,
            'amount_to_pay' => $amountToPay,
            'total_amount_payable' => $combo->sale_price,
            'total_amount_paid' => $totalAmountPaid,
            'payment_duration' => $order->payment_duration,
            'payment_mode' => $order->payment_mode,
            'balance_remaining' => $remainingBalance,
            'payment_history' => $paymentHistory,
        ]);
    }
    
    

}
