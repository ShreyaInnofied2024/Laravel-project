<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // Ensures user is authenticated
    }

    // Display the cart
    public function index()
    {
        $user_id = Auth::id();
        $cartItems = Cart::getUserCart($user_id);
        $totalItems = Cart::getTotalItems($user_id);
        $totalPrice = Cart::getTotalPrice($user_id);

        return view('cart.view', compact('cartItems', 'totalItems', 'totalPrice'));
    }

    // Add a product to the cart
    public function add($product_id)
    {
        $user_id = Auth::id();
        $quantity = 1;

        // Check if the product exists
        $product = Product::find($product_id);
        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'Product not found');
        }

        // Check if the product is already in the cart
        $cartItem = Cart::getCartItem($user_id, $product_id);

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if ($newQuantity <= $product->quantity) {
                Cart::updateQuantity($user_id, $product_id, $newQuantity);
            } else {
                return redirect()->route('cart.index')->with('error', 'Cannot add more than available stock.');
            }
        } else {
            Cart::addToCart($user_id, $product_id, $quantity);
        }

        return redirect()->route('cart.index');
    }

    // Increase the quantity of a product
    public function increase($product_id)
    {
        $user_id = Auth::id();
        $cartItem = Cart::getCartItem($user_id, $product_id);
        $product = Product::find($product_id);

        if ($cartItem && $product) {
            $newQuantity = $cartItem->quantity + 1;

            if ($newQuantity <= $product->quantity) {
                Cart::updateQuantity($user_id, $product_id, $newQuantity);
            } else {
                return redirect()->route('cart.index')->with('error', 'Cannot add more than available stock.');
            }
        }

        return redirect()->route('cart.index');
    }

    // Decrease the quantity of a product
    public function decrease($product_id)
    {
        $user_id = Auth::id();
        $cartItem = Cart::getCartItem($user_id, $product_id);

        if ($cartItem && $cartItem->quantity > 1) {
            $newQuantity = $cartItem->quantity - 1;
            Cart::updateQuantity($user_id, $product_id, $newQuantity);
        } else {
            Cart::removeFromCart($user_id, $product_id);
        }

        return redirect()->route('cart.index');
    }

    // Remove a product from the cart
    public function remove($product_id)
    {
        $user_id = Auth::id();
        Cart::removeFromCart($user_id, $product_id);

        return redirect()->route('cart.index');
    }

    // Clear the cart
    public function clear()
    {
        $user_id = Auth::id();
        Cart::clearCart($user_id);

        return redirect()->route('cart.index');
    }
}
