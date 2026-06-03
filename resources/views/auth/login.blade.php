@extends('layouts.app')

@section('title', 'Login - KursusKomari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" alt="PT Komari">
            <h2>Login Akun</h2>
            <p>Masuk untuk memilih paket kursus yang kamu inginkan.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="post" class="auth-form" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>

        <p class="switch">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar di sini</a>
        </p>

        <p class="switch">
            <a href="{{ url('/') }}">← Kembali ke beranda</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
