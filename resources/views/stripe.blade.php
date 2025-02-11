<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #cfe2f6;
        }

        .payment-form {
            max-width: 500px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fffcfc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .payment-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container col-md-4">
        <div class="card mt-5">
            <div class="card-header">
                <h4>Make Payment</h4>
            </div>
            <div class="card-body">
                @session('success')
                    <div class="alert alert-success">{{$value}}</div>
                @endsession

                <div class="p-3 bg-light bg-opacity-10">
                    <h6 class="card-title mb-3">Order Summary</h6>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Subtotal: </span><span>$190.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Shipping: </span><span>$20.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Coupon (Code:ADARSH) </span><span class="text-danger">-$10.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Total</span><strong>${{$bill}}</strong>
                    </div>
                    <form action="{{route('stripe.charge')}}" method="POST" id="stripe-form">
                        @csrf                  
                        <input type="hidden" value="{{$fullname}}" name="fullname">
                        
                        <input type="hidden" value="{{$address}}" name="address">

                        <input type="hidden" value="{{$phone}}" name="phone">

                        <input type="hidden" name="bill" value="{{$bill}}">
                        
                        <input type="hidden" name="stripeToken" id="stripe-token">
                        <div id="card-element" class="form-control"></div>
                        <button class="btn btn-success w-100 mt-2" type="button" onclick="createToken()">Submit</button>
                    </form>

                   
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{env('STRIPE_KEY')}}');

        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        function createToken() {
            stripe.createToken(cardElement).then(function (result) {
                console.log(result);
                if (result.token) {
                    document.getElementById('stripe-token').value = result.token.id;
                    document.getElementById('stripe-form').submit();
                }
            });
        }
    </script>
</body>

</html>