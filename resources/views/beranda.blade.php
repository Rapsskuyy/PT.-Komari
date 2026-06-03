@extends('layouts.app')

@section('title', 'PT Komari - Les Privat')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI</span>
    </div>

    <ul class="nav-menu">
        <li><a href="#home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#about"><i class="fa fa-user"></i> Tentang kami</a></li>
        <li><a href="#services"><i class="fa fa-book"></i> Layanan</a></li>
        <li><a href="#profile"><i class="fa fa-user-circle"></i> Profile</a></li>
    </ul>

    <div class="nav-right">
        @guest
            <a href="{{ route('login') }}" class="btn-daftar">Login</a>
        @else
            <span class="nav-user">
                Halo, {{ auth()->user()->username }} ({{ auth()->user()->role }})
            </span>

            @if(auth()->user()->role === 'siswa')
                <a href="{{ route('courses.index') }}" class="btn-riwayat">Paket Saya</a>
            @else
                <a href="#" class="btn-riwayat">Riwayat</a>
                <a href="#" class="btn-keuangan">Keuangan</a>
            @endif

            <form method="POST" action="{{ url('/logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @endguest
    </div>
</nav>

@if(session('login_success'))
    <div class="alert success">
        Login berhasil. Selamat datang 👋
    </div>
@endif

<section class="hero" id="home">
    <div class="hero-left" data-animate data-delay="0ms">
        <h1>Belajar Lebih Mudah, Raih <br>Prestasi Lebih Tinggi</h1>
        <p>Bimbel terbaik untuk siswa SMA & SMK yang siap sukses menghadapi ujian sekolah, UTBK, dan dunia kerja.</p>
        <a class="btn-contact" href="#services">Lihat Paket</a>
    </div>

    <div class="hero-right" data-animate="right" data-delay="150ms">
        <img src="{{ asset('pic/mhsw1-removebg-preview-removebg-preview.png') }}" class="png" alt="">
        <img src="{{ asset('pic/mhsw3-removebg-preview-removebg-preview.png') }}" class="png" alt="">
    </div>
</section>

<section class="about" id="about">
    <div class="about-left" data-animate="left" data-delay="0ms">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="about-logo" alt="">
        <h2>Tentang Kami</h2>
        <p>
            Kami adalah lembaga penyedia layanan jasa les privat untuk TK, SD, SMP, SMA, UN, OSN, SNBT & Mahasiswa.
            Guru datang ke rumah atau online, dengan materi sesuai kurikulum dan gaya belajar siswa.
        </p>
    </div>

    <div class="about-right" data-animate="right" data-delay="100ms">
        <h2>Mengapa memilih kami?</h2>
        <ul>
            <li>Expert dan berpengalaman</li>
            <li>Materi lengkap & mudah dipahami</li>
            <li>Biaya les privat terjangkau</li>
            <li>Jadwal fleksibel sesuai kebutuhan</li>
            <li>Tim support yang supportif dan solutif</li>
        </ul>
    </div>
</section>

<section class="services" id="services">
    <h2 data-animate data-delay="0ms">Layanan Kami</h2>

    <div class="service-grid">
        @forelse($packages as $index => $row)
            @php
                $icon = asset('pic/pt.komari-removebg-preview-removebg-preview.png');
                $nameLower = strtolower($row->name);
                if (strpos($nameLower, 'math') !== false || strpos($nameLower, 'matematika') !== false) {
                    $icon = asset('pic/math-removebg-preview-removebg-preview.png');
                } elseif (strpos($nameLower, 'inggris') !== false || strpos($nameLower, 'english') !== false) {
                    $icon = asset('pic/ngra_ing-removebg-preview-removebg-preview.png');
                } elseif (strpos($nameLower, 'ipa') !== false || strpos($nameLower, 'sains') !== false) {
                    $icon = asset('pic/mikroskop-removebg-preview-removebg-preview.png');
                } elseif (strpos($nameLower, 'ips') !== false || strpos($nameLower, 'sosial') !== false) {
                    $icon = asset('pic/globe-removebg-preview-removebg-preview.png');
                }
                $cardDelay = $index * 80;
            @endphp
            <div class="card" data-animate="scale" data-delay="{{ $cardDelay }}ms">
                <img src="{{ $icon }}" class="icon-flag" alt="{{ $row->name }}">
                <h3>{{ $row->name }}</h3>
                <p>{{ $row->description }}</p>
                <p style="font-weight: 800; color: var(--accent); margin-bottom: 12px;">{{ 'Rp ' . number_format($row->price, 0, ',', '.') }}</p>

                <form action="{{ route('orders.create') }}" method="get">
                    <input type="hidden" name="paket_id" value="{{ $row->id }}">
                    <button type="submit" class="btn-beli">Pilih Paket</button>
                </form>
            </div>
        @empty
            <p>Tidak ada paket tersedia saat ini.</p>
        @endforelse
    </div>
</section>

<section class="profile" id="profile">
    <h2 data-animate data-delay="0ms">Our Profile</h2>

    <div class="profile-grid">
        <div class="pop-card" data-animate="scale" data-delay="0ms">
            <img src="{{ asset('pic/rafa.jpg') }}" alt="Raffa">
            <h3>Raffa Nur Musyaffa</h3>
            <p>@rrapskuy</p>
        </div>

        <div class="pop-card" data-animate="scale" data-delay="80ms">
            <img src="{{ asset('pic/fadhli.jpg') }}" alt="Fadhli">
            <h3>Fadhli Khoirul Abrar</h3>
            <p>@padelparker</p>
        </div>

        <div class="pop-card" data-animate="scale" data-delay="160ms">
            <img src="{{ asset('pic/zul.jpg') }}" alt="Zul">
            <h3>Zuliansyah Anggara</h3>
            <p>@zulian_zilong</p>
        </div>

        <div class="pop-card" data-animate="scale" data-delay="240ms">
            <img src="{{ asset('pic/alfha.jpg') }}" alt="Alfha">
            <h3>Alfharidzi Hamka</h3>
            <p>@zeljgz</p>
        </div>

        <div class="pop-card" data-animate="scale" data-delay="320ms">
            <img src="{{ asset('pic/evan.jpg') }}" alt="Evan">
            <h3>Evan Fadhilah</h3>
            <p>@_epanpadilah</p>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-top">
        <div class="footer-brand">
            <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" alt="PT Komari" class="footer-logo">
            <h3>PT KOMARI</h3>
            <p>Belajar lebih mudah, prestasi lebih tinggi.</p>
        </div>

        <div class="footer-links">
            <h4>Menu</h4>
            <ul>
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#services">Layanan</a></li>
                <li><a href="#profile">Profile</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h4>Kontak</h4>
            <p><i class="fa-solid fa-location-dot"></i> Depok, Jawa Barat</p>
            <p><i class="fa-solid fa-envelope"></i> info@ptkomari.com</p>
            <p><i class="fa-brands fa-whatsapp"></i> 0815-xxxx-xxxx</p>

            <div class="footer-social">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 PT Komari. All rights reserved.</p>
    </div>
</footer>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
