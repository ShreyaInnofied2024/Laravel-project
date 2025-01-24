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
use App\Mail\PaymentSuccessMail;

class OrderController extends Controller
{
    private $stripeServices;

    public function __construct()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
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
        $cartItems = $cartItems = Cart::with('product')->where('user_id', $user_id)->get();
        $address = $request->input('selected_address_id');
        $paymentMethod = $request->input('payment_method');
        $totalPrice = Cart::getTotalPrice($user_id);
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
                'price' => $cartItem->product->price,
            ]);
        }



        // Redirect to payment gateway (PayPal/Stripe)
        if ($paymentMethod == 'PayPal') {
            return redirect()->route('paypal.index', ['order' => $order]);
        }

        if ($paymentMethod == 'Stripe') {
            $stripeLineItems = [];

            foreach ($cartItems as $cartItem) {

                $stripeLineItems[] = [
                    'price_data' => [
                        'currency' => 'usd', // Replace with your currency
                        'product_data' => [
                            'name' => $cartItem->product->name, // Product name
                        ],
                        'unit_amount' => $cartItem->product->price * 100, // Price in cents
                    ],
                    'quantity' => $cartItem->quantity,
                ];
            }

            // Create Stripe Checkout Session
            $checkoutSession = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $stripeLineItems, // Correctly structured items
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order' => $order->id]),
                'cancel_url' => route('payment.cancel', ['order' => $order->id]),
            ]);

            return redirect($checkoutSession->url);
        }



        return redirect()->route('order.cancel');
    }
    public function paymentSuccess($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Mark the order as paid
        $order->update(['status' => 'Paid']);
        $user_id = Auth::id();  // Assuming you use Auth to get the logged-in user's ID
        $products = Cart::getUserCart($user_id);


        foreach ($products as $product) {
            $product_id = $product->product_id;
            $quantity = $product->quantity;
    
            $product = Product::findOrFail($product_id);

            if ($product->quantity >= $quantity) {
                $product->update(['quantity' => $product->quantity - $quantity]);
            } 
    
        }
    

        // Clear the user's cart
        Cart::where('user_id', Auth::id())->delete();

        Mail::to($order->user->email)->send(new PaymentSuccessMail($order));

        return view('orders.success', compact('order'));
    }

    public function paymentCancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Mark the order as canceled
        $order->update(['status' => 'Canceled']);

        return view('orders.cancel', compact('order'));
    }


    public function history()
    {
        $user = Auth::user();

        // Retrieve all orders for the logged-in user
        $orders = $user->orders()->with('items.product')->get();

        return view('orders.history', compact('orders'));
    }


    public function details($id)
    {

        $orderInfo = Order::findOrFail($id);
        $orderItems = OrderItems::with('product') // Assuming you have a relationship set up for product
            ->where('order_id', $id)
            ->get();

        return view('orders.details', compact('orderInfo', 'orderItems'));
    }


    public function admin_index()
    {
        $orders = Order::with('user')->whereIn('status', ['Paid', 'Out for Delivery', 'Completed'])->paginate(10); // Fetch orders with user info for pagination
        return view('admin.orders.index', compact('orders'));
    }

    // Update order status
    public function admin_update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Processing,Out for Delivery,Completed',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }

}
