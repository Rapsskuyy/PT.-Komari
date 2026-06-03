@extends('layouts.app')

@section('title', 'Detail Kursus - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .course-detail-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .course-header { background: linear-gradient(135deg, #334155 0%, #1E293B 100%); padding: 48px; border-radius: 24px; margin-bottom: 32px; }
    .course-header h1 { font-size: 36px; font-weight: 800; color: white; margin-bottom: 16px; }
    .course-header .price { font-size: 28px; font-weight: 800; color: var(--accent); }
    .course-content { background: #1E293B; padding: 32px; border-radius: 24px; border: 1px solid #334155; margin-bottom: 32px; }
    .course-content h2 { font-size: 24px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; }
    .course-content p { color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; }
    .rating-section { background: #1E293B; padding: 32px; border-radius: 24px; border: 1px solid #334155; }
    .rating-section h2 { font-size: 24px; font-weight: 700; color: var(--text-main); margin-bottom: 24px; }
    .rating-form input[type="range"] { width: 100%; margin-bottom: 16px; }
    .rating-form textarea { width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #334155; background: #0F172A; color: white; margin-bottom: 16px; resize: vertical; }
    .btn-primary { background: var(--accent); color: #0F172A; padding: 12px 24px; border-radius: 12px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s; }
    .btn-primary:hover { background: var(--accent-hover); }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('courses.index') }}" class="btn-daftar">Kembali</a>
    </div>
</nav>

<div class="course-detail-wrapper">
    <div class="course-header">
        <h1>{{ $course->name }}</h1>
        <div class="price">{{ 'Rp ' . number_format($course->price, 0, ',', '.') }}</div>
    </div>

    <div class="course-content">
        <h2>Deskripsi</h2>
        <p>{{ $course->description }}</p>
    </div>

    <div class="rating-section">
        <h2>Beri Rating</h2>
        <form action="{{ route('cart.add', $course->id) }}" method="POST" class="rating-form" style="margin-bottom: 24px;">
            @csrf
            <button type="submit" class="btn-primary">Tambah ke Keranjang</button>
        </form>
        <form action="{{ route('ratings.store') }}" method="POST" class="rating-form">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div>
                <label style="color: var(--text-muted); margin-bottom: 8px; display: block;">Rating (1-5)</label>
                <input type="number" name="rating" min="1" max="5" value="5" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #334155; background: #0F172A; color: white;">
            </div>
            <div>
                <label style="color: var(--text-muted); margin-bottom: 8px; display: block;">Review (opsional)</label>
                <textarea name="review" rows="4" placeholder="Tulis review kamu di sini..."></textarea>
            </div>
            <button type="submit" class="btn-primary">Kirim Rating</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
