<?php

namespace App\Http\Controllers;

use App\Models\Cart;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get all carts.
     */
    public function index()
    {
        $carts = Cart::with('items')->get();
        return response()->json($carts);
    }

    /**
     * Create a new cart.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Create a new cart
        $cart = Cart::create([
            'user_id' => $validatedData['user_id'],
            'total' => 0,
            'grand_total' => 0,
        ]);

        return response()->json($cart, 201);  // HTTP status 201 (Created)
    }

    /**
     * Get a specific cart by ID.
     */
    public function show($id)
    {
        $cart = Cart::with('items')->findOrFail($id);
        return response()->json($cart);
    }

    /**
     * Clear all items from the cart.
     */
    public function clearCart($cart_id)
    {
        $cart = Cart::findOrFail($cart_id);
        $cart->items()->delete(); // Remove all cart items

        // Reset the cart's total and grand total
        $cart->update([
            'total' => 0,
            'grand_total' => 0,
        ]);

        return response()->json($cart->load('items'), 200); // HTTP status 200 (OK)
    }

    /**
     * Delete a cart.
     */
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully']);
    }


    public function getCartItemsByUser($user_id)
    {
        // Find the cart associated with the user
        $cart = Cart::where('user_id', $user_id)->first();

        // If no cart found for the user
        if (!$cart) {
            return response()->json([
                'message' => 'No cart found for this user',
            ], 404);
        }

        // Get the items in the user's cart
        $cartItems = CartItem::where('cart_id', $cart->id)->with('item')->get();

        return response()->json([
            'cart' => $cart,
            'cart_items' => $cartItems
        ], 200);
    }
}
