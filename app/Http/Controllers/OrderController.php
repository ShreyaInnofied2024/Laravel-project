<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\OrderItems;
use App\Models\Product;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private $stripeServices;

    public function __construct()
    {
        // $this->stripeServices = new StripeService();
    }

    public function checkout()
    {
        $user_id = Auth::id();
        $cartItems = Cart::where('user_id', $user_id)->get();
        $totalItems = Cart::getTotalItems($user_id);
        $totalPrice = Cart::getTotalPrice($user_id);
        $addresses = Auth::user()->addresses;

        return view('orders.index', compact('cartItems', 'totalItems', 'totalPrice', 'addresses'));
    }

    public function payment(Request $request)
    {
        $user_id = Auth::id();
        $cartItems = Cart::where('user_id', $user_id)->get();
        $address = $request->input('selected_address');
        $paymentMethod = $request->input('payment_method');
        $totalPrice = $cartItems->sum('total_price');

        // Save order
        $order = Order::create([
            'user_id' => $user_id,
            'address' => $address,
            'total_amount' => $totalPrice,
            'shipping_method' => $paymentMethod,
        ]);

        // Save order items
        foreach ($cartItems as $cartItem) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', $user_id)->delete();

        // Redirect to payment gateway (PayPal/Stripe)
        if ($paymentMethod == 'PayPal') {
            return redirect()->route('paypal.index', ['order' => $order]);
        }

        if ($paymentMethod == 'Stripe') {
            $checkoutURL = $this->stripeServices->createCheckoutSession($cartItems, $user_id);
            return redirect($checkoutURL);
        }

        return redirect()->route('order.cancel');
    }

    public function success()
    {
        $orderId = session('pending_order_id');
        $order = Order::findOrFail($orderId);

        // Update order status and stock
        $order->update(['status' => 'completed']);

        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $product->decrement('quantity', $item->quantity);
        }

        // Send email confirmation
        $this->sendOrderConfirmationEmail($order);

        return view('order.success');
    }

    public function cancel()
    {
        // Handle order cancellation logic
        return view('order.cancel');
    }

    public function history()
    {
        $orders = Auth::user()->orders;
        return view('order.history', compact('orders'));
    }

    public function details(Order $order)
    {
        return view('order.details', compact('order'));
    }

    private function sendOrderConfirmationEmail(Order $order)
    {
        $user = Auth::user();
        $emailData = [
            'order' => $order,
            'user' => $user,
        ];

        // Mail::to($user->email)->send(new OrderConfirmationEmail($emailData));
    }
}
