<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
        ]);

        // Fetch item price
        $item = Item::find($validatedData['item_id']);
        $totalPrice = $item->price * $validatedData['qty'];

        // Create a new cart item
        $cartItem = CartItem::create([
            'cart_id' => $validatedData['cart_id'],
            'item_id' => $validatedData['item_id'],
            'qty' => $validatedData['qty'],
            'price' => $item->price,
            'total' => $totalPrice,
        ]);

        // Update cart total
        $cart = Cart::findOrFail($validatedData['cart_id']);
        $cart->total += $totalPrice;
        $cart->grand_total += $totalPrice;
        $cart->save();

        return response()->json($cartItem, 201);  // HTTP status 201 (Created)
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cart = Cart::findOrFail($cartItem->cart_id);

        // Recalculate the total price for the updated quantity
        $newTotal = $cartItem->price * $validatedData['qty'];
        $cart->total -= $cartItem->total;  // Subtract old total
        $cart->total += $newTotal;         // Add new total

        // Update cart grand total as well
        $cart->grand_total = $cart->total;
        $cart->save();

        // Update the cart item
        $cartItem->update([
            'qty' => $validatedData['qty'],
            'total' => $newTotal,
        ]);

        return response()->json($cartItem);
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cart = Cart::findOrFail($cartItem->cart_id);

        // Subtract the item's total from the cart
        $cart->total -= $cartItem->total;
        $cart->grand_total = $cart->total;
        $cart->save();

        // Delete the cart item
        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully']);
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

        // Get the items in the user's cart along with their names
        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('item:id,ku,ar,en')  // Include the item names (ku, ar, en)
            ->get();

        // Format the response
        return response()->json([
            'cart' => $cart,
            'cart_items' => $cartItems->map(function ($cartItem) {
                return [
                    'id' => $cartItem->id,
                    'cart_id' => $cartItem->cart_id,
                    'item_id' => $cartItem->item_id,
                    'qty' => $cartItem->qty,
                    'price' => $cartItem->price,
                    'total' => $cartItem->total,
                    'created_at' => $cartItem->created_at,
                    'updated_at' => $cartItem->updated_at,
                    'item_name_ku' => $cartItem->item->ku,
                    'item_name_ar' => $cartItem->item->ar,
                    'item_name_en' => $cartItem->item->en,
                ];
            })
        ], 200);
    }
}

