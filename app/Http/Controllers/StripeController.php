<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Stripe\StripeClient;

class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        $fullname = $request->input('fullname');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $bill = $request->input('bill');

        return view('stripe', compact('fullname', 'address', 'phone', 'bill'));
    }

    public function charge(Request $request)
    {

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $charge = $stripe->charges->create([
            'amount' => $request->bill * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payments done from',
        ]);

        dd($charge);
    }
}
