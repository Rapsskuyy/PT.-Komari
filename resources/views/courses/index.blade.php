@extends('layouts.app')

@section('title', 'Daftar Kursus - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .courses-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
    .course-card { background: #1E293B; border-radius: 24px; padding: 32px; border: 1px solid #334155; box-shadow: var(--shadow); transition: all 0.3s ease; }
    .course-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
    .course-card h3 { font-size: 20px; font-weight: 700; margin-bottom: 8px; color: var(--text-main); }
    .course-card .price { font-size: 18px; font-weight: 800; color: var(--accent); margin-bottom: 16px; }
    .course-card .meta { font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }
    .btn-action { display: block; text-align: center; padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 700; transition: all 0.3s; }
    .btn-buy { background: var(--accent); color: #0F172A; }
    .btn-buy:hover { background: var(--accent-hover); }
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

<div class="courses-wrapper">
    <h2 class="section-title">Daftar Kursus</h2>
    <div class="grid">
        @foreach($courses as $course)
            <div class="course-card">
                <h3>{{ $course->name }}</h3>
                <div class="price">{{ 'Rp ' . number_format($course->price, 0, ',', '.') }}</div>
                <div class="meta">{{ $course->description }}</div>
                <a href="{{ route('courses.show', $course->id) }}" class="btn-action btn-buy">Lihat Detail</a>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
