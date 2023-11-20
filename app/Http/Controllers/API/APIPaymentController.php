<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class APIPaymentController extends Controller
{
    public function makePayment(Request $request)
    {
        // Validate the request
        $request->validate([
            'orderId' => 'required|exists:orders,id',
            'paymentAmount' => 'required|numeric|min:0.01', // Adjust validation rules as needed
        ]);

        // Create a new payment
        $payment = new Payment();
        $payment->order_id = $request->input('orderId');
        $payment->amount = $request->input('paymentAmount');
        $payment->payment_date = Carbon::now(); // Assuming current date and time for payment_date
        $payment->save();

        // You can perform additional logic here, such as updating the order status

        return response()->json(['message' => 'Payment successful', 'payment' => $payment], 200);
    }

}
