<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';  // Adjust this if your table name is different
    protected $fillable = ['user_id', 'product_id', 'quantity'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Get the cart items for a user
    public static function getUserCart($user_id)
    {
        return self::where('user_id', $user_id)->with('product')->get();
    }

    // Get the total number of items in the cart
    public static function getTotalItems($user_id)
    {
        return self::where('user_id', $user_id)->sum('quantity');
    }

    // Get the total price of items in the cart
    public static function getTotalPrice($user_id)
    {
        $cartTotal = Cart::join('products', 'carts.product_id', '=', 'products.id')
        ->sum(DB::raw('carts.quantity * products.price'));

        return $cartTotal;
    }

    // Check if a cart item exists for a user and product
    public static function getCartItem($user_id, $product_id)
    {
        return self::where('user_id', $user_id)
                   ->where('product_id', $product_id)
                   ->first();
    }

    // Add a product to the cart
    public static function addToCart($user_id, $product_id, $quantity)
    {
        return self::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
        ]);
    }

    // Update the quantity of a product in the cart
    public static function updateQuantity($user_id, $product_id, $quantity)
    {
        $cartItem = self::getCartItem($user_id, $product_id);
        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
        }
    }

    // Remove a product from the cart
    public static function removeFromCart($user_id, $product_id)
    {
        return self::where('user_id', $user_id)
                   ->where('product_id', $product_id)
                   ->delete();
    }

    // Clear the entire cart
    public static function clearCart($user_id)
    {
        return self::where('user_id', $user_id)->delete();
    }
}

