<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Get all orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::where('visible', true)->get(); // Using Eloquent to retrieve all orders
        return response()->json($orders);
    }

    /**
     * Get a specific order by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Get order items
        $orderItems = OrderItem::where('order_id', $id)->get();

        return response()->json([
            'order' => $order,
            'items' => $orderItems,
        ]);
    }

    /**
     * Create a new order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'total' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $orderId = Order::create($data)->id; // Using Eloquent to create the order

        return response()->json(['id' => $orderId], 201);
    }

    /**
     * Update an existing order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|integer',
            'total' => 'sometimes|numeric',
            'grand_total' => 'sometimes|numeric',
            'status' => 'sometimes|string',
        ]);

        $updated = Order::where('id', $id)->update($data);

        if ($updated) {
            return response()->json(['message' => 'Order updated successfully']);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }

    /**
     * Delete an order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deleted = Order::where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Order deleted successfully']);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }

    /**
     * Create order items for a specific order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeItems(Request $request, $orderId)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|integer',
            'items.*.qty' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        foreach ($data['items'] as $item) {
            $item['order_id'] = $orderId;
            $item['total'] = $item['qty'] * $item['price'];

            OrderItem::create($item); // Using Eloquent to insert order items
        }

        return response()->json(['message' => 'Order items added successfully'], 201);
    }

    /**
     * Create an order from a cart.
     *
     * @param  int  $cart_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrderFromCart($cart_id)
    {
        // Step 1: Retrieve cart information
        $cart = Cart::find($cart_id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        // Step 2: Retrieve cart items
        $cartItems = CartItem::where('cart_id', $cart_id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'No items in the cart'], 400);
        }

        // Step 3: Calculate total and grand_total
        $total = $cartItems->sum('total'); // Assuming you have total in cart_items
        $grand_total = $total; // Additional fees can be added here

        // Step 4: Create a new order
        $order = Order::create([
            'user_id' => $cart->user_id,
            'total' => $total,
            'grand_total' => $grand_total,
            'status' => 'pending',
        ]);

        // Step 5: Insert order items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'qty' => $cartItem->qty,
                'price' => $cartItem->price,
                'total' => $cartItem->total,
            ]);
        }

        // Step 6: Delete the cart items
        CartItem::where('cart_id', $cart_id)->delete();

        // Step 7: Delete the cart itself
        $cart->delete();

        // Return the created order
        return response()->json(['order_id' => $order->id, 'message' => 'Order created successfully, cart deleted'], 201);
    }
}
