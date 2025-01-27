<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .cart-item {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .cart-item img {
            width: 150px;
            height: auto;
            border-radius: 8px;
        }
        .cart-item-details {
            flex-grow: 1;
            margin-left: 20px;
        }
        .cart-item-details h5 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .cart-item-details p {
            margin: 0;
        }
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .quantity-controls span {
            min-width: 30px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }
        .cart-summary {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: sticky;
            top: 20px;
        }
        .cart-summary h5 {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .cart-summary .total {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .btn-lg {
            padding: 15px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    @include('inc.header')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Shopping Cart</h1>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($cartItems->isNotEmpty())
            <div class="row">
                <!-- Cart Items -->
                <div class="col-md-8">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product_name }}" class="img-fluid">
                            <div class="cart-item-details">
                                <h5>{{ $item->product->name  }}</h5>
                                <p>
                                    <span class="text-muted text-decoration-line-through">Rs {{ number_format($item->original_price, 2) }}</span>
                                    <span class="text-success">Rs {{ number_format($item->product->price, 2) }}</span>
                                    <span class="text-danger">({{ $item->discount }}% off)</span>
                                </p>
                            </div>
                            <div class="cart-item-actions">
                                <div class="quantity-controls">
                                <form action="{{ route('cart.decrease', $item->product_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning btn-sm">-</button>
                            </form>
                            <span>{{ $item->quantity }}</span>

                                <form action="{{ route('cart.increase', $item->product_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">+</button>
                            </form>
                                </div>
                            
                            <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cart Summary -->
                <div class="col-md-4">
                    <div class="cart-summary">
                        <h5>PRICE DETAILS</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>Price ({{ $cartItems->count() }} items)</p>
                            <p>Rs {{ number_format($totalPrice, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Discount</p>
                            <p class="text-success">- Rs 0</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Delivery Charges</p>
                            <p class="text-success">Free</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Amount</strong>
                            <strong class="total">Rs {{ number_format($totalPrice - 0, 2) }}</strong>
                        </div>
                        <p class="text-success mt-2">You will save Rs 0 on this order</p>
                    </div>
                    <a href="{{route('order.checkout')}}" class="btn btn-success btn-lg w-100 mt-3">Place Order</a>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center" role="alert">
                Your cart is empty.
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back To Products</a>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
