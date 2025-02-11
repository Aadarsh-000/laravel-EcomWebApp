<x-header />

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Shopping Cart</h4>
                    <div class="breadcrumb__links">
                        <a href="./index.html">Home</a>
                        <a href="./shop.html">Shop</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($cartItem->count() == 0)
                    <div class="alert alert-danger">
                        <h2>Your cart is empty!</h2>
                    </div>
                @endif    
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(session()->has('success'))
                              <div class="alert alert-success">
                                 {{session()->get('success')}}
                              </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                     {{session()->get('error')}}
                                </div>
                            @endif   
                            
                            @php
                                $total = 0;
                            @endphp
                            
                            @foreach($cartItem as $item)
                                <tr>

                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img width="100px" src="{{asset('uploads/products/' . $item->picture)}}" alt="">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$item->title}}</h6>
                                            <h5>${{$item->price}}</h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                    <form action="{{route('updateCart')}}" method="POST">
                                        @csrf
                                        <div class="quantity">
                                            <input type="number" min="1" max="{{$item->pQuantity}}" class="form-control" name="quantity"
                                                value="{{$item->quantity}}">

                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <button type="submit" class="btn btn-success btn-block my-1">Update</button>
                                        </div>
                                    </form>
                                    </td>
                                    <td class="cart__price">${{$item->price * $item->quantity}}</td>
                                    <td class="cart__close"><a href="{{route('deleteCartItem',["id"=>$item->id])}}"><i class="fa fa-close"></i></a></td>

                                </tr>
                                @php 
                                     $total += $item->price * $item->quantity;
                                @endphp
                                  @php
                                  session()->put('total',$total);
                              @endphp
                            @endforeach

                          

                           

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="{{route('home')}}">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn update__btn">
                            <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__discount">
                    <h6>Discount codes</h6>
                    <form action="#">
                        <input type="text" placeholder="Coupon code">
                        <button type="submit">Apply</button>
                    </form>
                </div>
                <div class="cart__total">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Subtotal <span>${{$total}}</span></li>
                        <li>Total <span>${{$total}}</span></li>
                    </ul>
                    <form action="{{route('stripe.form')}}" method="POST">
                        @csrf
                        <input type="text" class="form-control" name="fullname" placeholder="Your Name" required>
                        
                        <input type="text" class="form-control mt-1" name="address" placeholder="Your Address" required>

                        <input type="text" class="form-control mt-1" name="phone" placeholder="Your Phone" required>

                        <input type="hidden" class="form-control mt-1" name="bill" value="{{$total}}">

                        <input type="submit" value="Proceed to checkout" class="primary-btn btn-block mt-1">
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->

<x-footer />