<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('inc.header')

<div class="container mt-5">
    <h1 class="text-center">Order #{{ $orderInfo->id }} Details</h1>

    <div class="card mt-3">
        <div class="card-header">
            <strong>Order Info</strong>
        </div>
        <div class="card-body">
            <p><strong>Status: {{ $orderInfo->status }}</strong></p>
            <p><strong>On: {{ $orderInfo->created_at }}</strong></p>
            <p><strong>Amount: ${{ number_format($orderInfo->total_amount, 2) }}</strong></p>
            <p><strong>Method: {{ $orderInfo->shipping_method }}</strong></p>
        </div>
    </div>

    <div class="mt-4">
        <h2>Products in Order</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-bottom:50px;" class="text-center">
            <a href="{{ route('order.history') }}" class="btn btn-secondary">Back to History</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
