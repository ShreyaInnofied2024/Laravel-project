<!-- resources/views/emails/payment_success.blade.php -->

<html>
    <body>
        <h1>Payment Successful</h1>
        <p>Dear {{ $order->user->name }},</p>
        <p>Your order (ID: {{ $order->id }}) has been successfully processed and paid.</p>
        <p>Order Details:</p>
        <!-- <ul>
            @foreach ($order->items as $item)
                <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: ${{ $item->price }}</li>
            @endforeach
        </ul> -->
        <p>Total Amount: ${{ $order->total_amount }}</p>
        <p>Thank you for shopping with us!</p>
    </body>
</html>
