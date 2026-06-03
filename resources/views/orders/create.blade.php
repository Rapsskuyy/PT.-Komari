@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .checkout-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
    .checkout-card { background: #1E293B; padding: 32px; border-radius: 24px; border: 1px solid #334155; margin-bottom: 24px; }
    .checkout-card h3 { font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; }
    .cart-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #334155; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item .name { color: var(--text-main); }
    .cart-item .price { color: var(--accent); font-weight: 700; }
    .total-row { display: flex; justify-content: space-between; padding: 16px 0; border-top: 2px solid #334155; margin-top: 16px; font-size: 24px; font-weight: 800; }
    .total-row .total { color: var(--accent); }
    .btn-checkout { background: var(--accent); color: #0F172A; padding: 16px 32px; border-radius: 12px; border: none; cursor: pointer; font-weight: 700; font-size: 18px; width: 100%; }
    .btn-checkout:hover { background: var(--accent-hover); }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('cart.index') }}" class="btn-daftar">Kembali ke Keranjang</a>
    </div>
</nav>

<div class="checkout-wrapper">
    <h2 class="section-title">Konfirmasi Pesanan</h2>

    <div class="checkout-card">
        <h3>Item Pesanan</h3>
        @foreach($cartItems as $item)
            <div class="cart-item">
                <span class="name">{{ $item->course->name }}</span>
                <span class="price">{{ 'Rp ' . number_format($item->course->price, 0, ',', '.') }}</span>
            </div>
        @endforeach
        <div class="total-row">
            <span>Total</span>
            <span class="total">{{ 'Rp ' . number_format($totalPrice, 0, ',', '.') }}</span>
        </div>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <button type="submit" class="btn-checkout">Buat Pesanan</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
