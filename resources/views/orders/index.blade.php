@extends('layouts.app')

@section('title', 'Riwayat Pesanan - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .orders-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
    .order-card { background: #1E293B; padding: 24px; border-radius: 16px; border: 1px solid #334155; margin-bottom: 16px; }
    .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #334155; }
    .order-header .order-id { font-size: 14px; color: var(--text-muted); }
    .order-header .status { padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; }
    .status.pending { background: rgba(251, 191, 36, 0.2); color: #FBBF24; }
    .status.paid { background: rgba(52, 211, 153, 0.2); color: #34D399; }
    .order-items { margin-bottom: 16px; }
    .order-item { display: flex; justify-content: space-between; padding: 8px 0; }
    .order-item .name { color: var(--text-main); }
    .order-item .price { color: var(--accent); font-weight: 700; }
    .order-total { text-align: right; font-size: 20px; font-weight: 800; color: var(--accent); }
    .btn-detail { display: inline-block; padding: 8px 16px; border-radius: 8px; background: #334155; color: white; text-decoration: none; font-size: 14px; transition: all 0.3s; }
    .btn-detail:hover { background: #475569; }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('dashboard') }}" class="btn-daftar">Dashboard</a>
        <a href="{{ route('cart.index') }}" class="btn-riwayat">Keranjang</a>
    </div>
</nav>

<div class="orders-wrapper">
    <h2 class="section-title">Riwayat Pesanan</h2>

    @if($orders->isEmpty())
        <div style="text-align: center; padding: 60px 0; color: var(--text-muted);">
            <div style="font-size: 64px; margin-bottom: 16px;">📦</div>
            <h3 style="font-size: 24px; margin-bottom: 8px;">Belum Ada Pesanan</h3>
            <p>Kamu belum memiliki pesanan apapun.</p>
            <a href="{{ route('courses.index') }}" style="display: inline-block; margin-top: 16px; color: var(--accent);">Lihat Kursus →</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <div class="order-id">Order #{{ $order->id }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <span class="status {{ $order->status }}">{{ $order->status }}</span>
                </div>
                <div class="order-items">
                    @foreach($order->orderItems as $item)
                        <div class="order-item">
                            <span class="name">{{ $item->course->name }}</span>
                            <span class="price">{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="order-total">Total: {{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}</div>
                <div style="margin-top: 16px; text-align: right;">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-detail">Detail</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
