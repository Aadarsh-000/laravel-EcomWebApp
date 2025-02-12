<x-header />

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8">
                <div class="section-title text-center">
                    <h2>My Order History</h2>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Total Bill</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($orders as $item)
                                <tr>

                                    <td>{{$i++}}</td>
                                    <td>{{$item->bill}}</td>
                                    <td>{{$item->fullname}}</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{$i}}">
                                            View
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$i}}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">All Products</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th>Sub Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($items as $product)
                                                                    @if($item->id == $product->id)
                                                                        <tr>
                                                                            <td><img src="{{asset('uploads/products/' . $product->picture)}}"
                                                                                    width="50px" alt=""></td>

                                                                            <td>
                                                                                {{$product->quantity}}
                                                                            </td>
                                                                            <td>
                                                                                {{$product->price}}
                                                                            </td>
                                                                            <td>
                                                                                {{$product->price * $product->quantity}}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<x-footer />

<style>
    .contact {
        padding: 100px 0;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    }

    .section-title h2 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .section-title p {
        font-size: 16px;
        color: #666;
    }

    .contact__form {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        height: 50px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 16px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-control-file {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .site-btn {
        background: black;
        color: #fff;
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .site-btn:hover {
        background: #310248;
        transform: translateY(-2px);
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }
</style>