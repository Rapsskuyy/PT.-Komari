@extends('layouts.app')

@section('title', 'Detail Pesanan - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .order-detail-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
    .order-card { background: #1E293B; padding: 32px; border-radius: 24px; border: 1px solid #334155; margin-bottom: 24px; }
    .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #334155; }
    .order-header .order-id { font-size: 14px; color: var(--text-muted); }
    .order-header .status { padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 700; }
    .status.pending { background: rgba(251, 191, 36, 0.2); color: #FBBF24; }
    .status.paid { background: rgba(52, 211, 153, 0.2); color: #34D399; }
    .order-items { margin-bottom: 24px; }
    .order-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #334155; }
    .order-item:last-child { border-bottom: none; }
    .order-item .name { color: var(--text-main); }
    .order-item .price { color: var(--accent); font-weight: 700; }
    .order-total { text-align: right; font-size: 24px; font-weight: 800; color: var(--accent); margin-top: 24px; padding-top: 24px; border-top: 2px solid #334155; }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('orders.index') }}" class="btn-daftar">Kembali ke Pesanan</a>
    </div>
</nav>

<div class="order-detail-wrapper">
    <h2 class="section-title">Detail Pesanan #{{ $order->id }}</h2>

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
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
