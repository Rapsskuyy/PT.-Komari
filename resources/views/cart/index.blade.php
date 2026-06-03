@extends('layouts.app')

@section('title', 'Keranjang - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .cart-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
    .cart-item { background: #1E293B; padding: 24px; border-radius: 16px; border: 1px solid #334155; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
    .cart-item-info h3 { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
    .cart-item-info .price { font-size: 16px; font-weight: 800; color: var(--accent); }
    .cart-actions { display: flex; gap: 12px; }
    .btn-remove { background: #EF4444; color: white; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; }
    .btn-checkout { background: var(--accent); color: #0F172A; padding: 12px 32px; border-radius: 12px; border: none; cursor: pointer; font-weight: 700; font-size: 16px; }
    .cart-summary { background: linear-gradient(135deg, #334155 0%, #1E293B 100%); padding: 32px; border-radius: 24px; margin-top: 32px; text-align: right; }
    .cart-summary .total { font-size: 32px; font-weight: 800; color: var(--accent); margin-bottom: 16px; }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('courses.index') }}" class="btn-daftar">Daftar Kursus</a>
        <a href="{{ route('dashboard') }}" class="btn-riwayat">Dashboard</a>
    </div>
</nav>

<div class="cart-wrapper">
    <h2 class="section-title">Keranjang Belanja</h2>

    @if($cartItems->isEmpty())
        <div style="text-align: center; padding: 60px 0; color: var(--text-muted);">
            <div style="font-size: 64px; margin-bottom: 16px;">🛒</div>
            <h3 style="font-size: 24px; margin-bottom: 8px;">Keranjang Kosong</h3>
            <p>Belum ada paket di keranjang kamu.</p>
            <a href="{{ route('courses.index') }}" style="display: inline-block; margin-top: 16px; color: var(--accent);">Lihat Kursus →</a>
        </div>
    @else
        @php
            $total = 0;
        @endphp
        @foreach($cartItems as $item)
            @php
                $total += $item->course->price;
            @endphp
            <div class="cart-item">
                <div class="cart-item-info">
                    <h3>{{ $item->course->name }}</h3>
                    <div class="price">{{ 'Rp ' . number_format($item->course->price, 0, ',', '.') }}</div>
                </div>
                <div class="cart-actions">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-remove">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="cart-summary">
            <div class="total">Total: {{ 'Rp ' . number_format($total, 0, ',', '.') }}</div>
            <form action="{{ route('orders.create') }}" method="GET">
                <button type="submit" class="btn-checkout">Checkout</button>
            </form>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
