<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(){


        $allProducts = Product::all();
        $newArrival = Product::where('type','new-arrivals')->get();
        $bestSeller = Product::where('type', 'Best sellers')->get();
        $hotSale = Product::where('type', 'sale')->get();

        return view('index', compact('allProducts', 'newArrival', 'bestSeller', 'hotSale'));

    }

    public function cart(){
        $cartItem = DB::table('carts')
        ->join('products', 'carts.productId', 'products.id')
        ->select('products.title','products.quantity as pQuantity', 'products.price', 'products.picture', 'carts.*')
        ->where('carts.customerId', session()->get('id'))
        ->get();

        return view('cart', compact('cartItem'));
    }

    public function checkoutItem(Request $data){
        if(session()->has('id')){
            $order = new Order();
            $order->status = "Pending";
            $order->customerId = session()->get('id');
            $order->bill = $data->input('bill');
            $order->address = $data->input('address');
            $order->phone = $data->input('phone');
            $order->fullname = $data->input('fullname');

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

            return redirect()->back()->with('success', 'Success! Your order has been placed successfully');
        }else{
            return redirect()->back()->with('error', 'Please Login to place orders.');
        }
    }

    public function shop(){
        return view('shop');
    }

    public function singleProduct($id){
        $product = Product::find($id);
        return view('singleProduct', compact('product'));
    }

    public function register(){
        return view('register');
    }

    public function registerUser(Request $data){

        $data->validate([
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newUser = new User();
        $newUser->fullname = $data->fullname;
        $newUser->email = $data->email;
        $newUser->password = $data->password;

        if ($data->hasFile('file')) {
            $newUser->picture = $data->file('file')->getClientOriginalName();
            $data->file('file')->move('uploads/profiles/', $newUser->picture);
        } else {
            // Handle the case where no file was uploaded
            $newUser->picture = 'default.jpg'; // or any default value
        }

        if($newUser->save()){
            return redirect()->route('login')->with('success', 'User registered successfully');
        }else{
            return redirect()->back()->with('error', 'Failed to register user');
        }
    }

    public function loginUser(Request $data){
        $user = User::where('email', $data->email)->where('password', $data->password)->first();
        if($user){
            session()->put('id',$user->id);
            session()->put('type',$user->type);

            if($user->type == 'customer'){
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function login(){
        return view('login');   
    }

    public function logout(){
        session()->forget('id');
        session()->forget('type');
        session()->forget('total');
        return redirect()->route('login');
    }

    public function addToCart(Request $data){
        if(session()->has('id')){
            $item = new Cart();
            $item->quantity = $data->input('quantity');
            $item->productId = $data->input('id');
            $item->customerId = session()->get('id');
            $item->save();

                 return redirect()->back()->with('success', 'Item added to cart successfully');
        }
        else
        {
            return redirect()->route('login')->with('error', 'Please login to add items to cart');
        }
    }

   public function deleteCartItem($id){
        $cartItem = Cart::find($id);
        if($cartItem->delete()){
            return redirect()->back()->with('success', 'Item removed from cart successfully');
        }
        else{
            return redirect()->back()->with('error', 'Failed to remove the item from0 cart');
        }
   }

   public function updateCart(Request $data){
        if(session()->has('id')){
        $cartItem =  Cart::find($data->id);
        $cartItem->quantity = $data->quantity;

        if($cartItem->save()){
            return redirect()->back()->with('success', 'Cart updated successfully');
        }
        else{
            return redirect()->back()->with('error', 'Failed to update cart');
        }
        }
        else{
            return redirect()->route('login')->with('error', 'Please login to update cart');
        }
    }
}
