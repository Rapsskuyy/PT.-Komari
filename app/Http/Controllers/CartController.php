<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('course')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add($packageId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($packageId);

        // Check if already in cart
        $existingCart = Cart::where('user_id', $user->id)
            ->where('course_id', $packageId)
            ->first();

        if ($existingCart) {
            return back()->with('info', 'Paket sudah ada di keranjang.');
        }

        Cart::create([
            'user_id' => $user->id,
            'course_id' => $packageId,
            'quantity' => 1,
        ]);

        return back()->with('success', 'Paket ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $cartItem->delete();
        return back()->with('success', 'Paket dihapus dari keranjang.');
    }

    public function checkout()
    {
        return redirect()->route('orders.create');
    }
}
