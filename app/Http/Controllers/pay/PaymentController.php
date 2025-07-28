<?php

namespace App\Http\Controllers\pay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function checkoutForm()
    {
        return view('checkout');
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        Charge::create([
            'amount' => 1000, // 10.00 USD
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Test Payment from Laravel'
        ]);

        return back()->with('success', 'Payment successful!');
    }
}
