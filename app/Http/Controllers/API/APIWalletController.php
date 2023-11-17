<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIWalletController extends Controller
{
    public function getWalletBalance(Request $request)
    {
        $user = $request->user();

        // Ensure the user has a wallet
        if (!$user->wallet) {
            return response()->json(['error' => 'User does not have a wallet.'], 404);
        }

        // Retrieve and return the wallet balance
        $balance = $user->wallet->balance;

        return response()->json(['balance' => $balance], 200);
    }
}
