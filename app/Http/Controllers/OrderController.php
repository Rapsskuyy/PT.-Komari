<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('orderItems.course')->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('course')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->course->price;
        }

        return view('orders.create', compact('cartItems', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('course')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Calculate total
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->course->price;
        }

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $item->course_id,
                'price' => $item->course->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat. Menunggu pembayaran.');
    }

    public function show($id)
    {
        $order = Order::with('orderItems.course', 'user')->findOrFail($id);
        
        // Check if user owns this order (security)
        if (auth()->id() !== $order->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan berhasil diupdate.');
    }
}
