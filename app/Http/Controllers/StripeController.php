<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Stripe\StripeClient;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderItem;

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
            'description' => 'Payments done from'. $request->fullname,
        ]);

        if(session()->has('id')){
            $order = new Order();
            $order->status = "Paid";
            $order->customerId = session()->get('id');
            $order->bill = $request->input('bill');
            $order->address = $request->input('address');
            $order->phone = $request->input('phone');
            $order->fullname = $request->input('fullname');

            if($order->save()){
                
                $carts = Cart::where('customerId', session()->get('id'))->get();

                foreach($carts as $item){

                    $product = Product::find($item->productId);

                    $orderItem = new OrderItem();
                    $orderItem->productId = $item->productId;
                    $orderItem->quantity = $item->quantity;
                    $orderItem->price = $product->price;
                    $orderItem->orderId = $order->id;
                    $orderItem->save();
                    $item->delete();


                }
            }

            return redirect()->route('cart')->with('success', 'Success! Your order has been placed. You will receive the product shortly.');
        }else{
            return redirect()->route('cart')->with('error', 'Please Login to place orders.');
        }
    }
}
