<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Paket yang sudah dibeli (status paid)
        $ownedOrders = $user->orders()->where('status', 'paid')->with('orderItems.course')->get();
        $ownedPackages = collect();
        foreach ($ownedOrders as $order) {
            foreach ($order->orderItems as $item) {
                if ($item->course) {
                    $ownedPackages->push($item->course);
                }
            }
        }
        $ownedPackages = $ownedPackages->unique('id')->values();
        $ownedIds = $ownedPackages->pluck('id')->toArray();

        // Paket tersedia (belum dibeli)
        $availablePackages = Course::where('is_active', true)
            ->whereNotIn('id', $ownedIds)
            ->get();

        // Pesanan pending (menunggu konfirmasi)
        $pendingOrders = $user->orders()->where('status', 'pending')->with('orderItems.course')->orderBy('created_at', 'desc')->get();

        // Jumlah item di keranjang
        $cartCount = $user->carts()->count();

        return view('dashboard', compact('ownedPackages', 'availablePackages', 'pendingOrders', 'cartCount'));
    }
}
