<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - PT Komari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B1120; color: #F1F5F9; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: 260px; background: #0F172A;
            border-right: 1px solid #1E293B;
            display: flex; flex-direction: column;
            z-index: 100; padding: 0;
        }
        .sidebar-brand {
            padding: 24px 24px 20px;
            border-bottom: 1px solid #1E293B;
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand img { height: 36px; }
        .sidebar-brand span { font-size: 16px; font-weight: 800; color: #F1F5F9; letter-spacing: -0.5px; }

        .sidebar-user {
            padding: 20px 24px;
            border-bottom: 1px solid #1E293B;
        }
        .user-avatar {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, #34D399, #059669);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; color: #0F172A;
            margin-bottom: 10px;
        }
        .user-name { font-size: 14px; font-weight: 700; color: #F1F5F9; margin-bottom: 2px; }
        .user-role { font-size: 12px; color: #64748B; }
        .user-badge {
            display: inline-block; margin-top: 6px;
            background: rgba(52,211,153,0.15); color: #34D399;
            border: 1px solid rgba(52,211,153,0.3);
            padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;
        }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-label { font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 1px; padding: 0 12px; margin: 16px 0 8px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px;
            color: #94A3B8; font-size: 14px; font-weight: 500;
            text-decoration: none; transition: all 0.2s; margin-bottom: 2px;
        }
        .nav-item i { width: 18px; text-align: center; font-size: 15px; }
        .nav-item:hover { background: #1E293B; color: #F1F5F9; }
        .nav-item.active { background: rgba(52,211,153,0.12); color: #34D399; font-weight: 700; }
        .nav-item.active i { color: #34D399; }
        .nav-badge {
            margin-left: auto; background: #EF4444; color: white;
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
        }
        .nav-badge.green { background: #34D399; color: #0F172A; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid #1E293B;
        }
        .btn-logout-side {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 10px 12px; border-radius: 10px;
            background: rgba(239,68,68,0.1); color: #F87171;
            border: 1px solid rgba(239,68,68,0.2);
            font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        }
        .btn-logout-side:hover { background: rgba(239,68,68,0.2); }

        /* ── MAIN CONTENT ── */
        .main { margin-left: 260px; min-height: 100vh; }

        /* ── TOPBAR ── */
        .topbar {
            background: #0F172A; border-bottom: 1px solid #1E293B;
            padding: 0 36px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-left h1 { font-size: 18px; font-weight: 800; color: #F1F5F9; }
        .topbar-left p { font-size: 12px; color: #64748B; margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 10px;
            font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;
        }
        .topbar-btn.primary { background: #34D399; color: #0F172A; }
        .topbar-btn.primary:hover { background: #10B981; }
        .topbar-btn.ghost { background: #1E293B; color: #94A3B8; border: 1px solid #334155; }
        .topbar-btn.ghost:hover { color: #F1F5F9; border-color: #475569; }

        /* ── PAGE CONTENT ── */
        .content { padding: 32px 36px; }

        /* ── ALERT ── */
        .alert {
            padding: 14px 18px; border-radius: 12px; margin-bottom: 24px;
            font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: rgba(52,211,153,0.1); color: #34D399; border: 1px solid rgba(52,211,153,0.25); }
        .alert-info { background: rgba(96,165,250,0.1); color: #60A5FA; border: 1px solid rgba(96,165,250,0.25); }
        .alert-warning { background: rgba(251,191,36,0.1); color: #FBBF24; border: 1px solid rgba(251,191,36,0.25); }

        /* ── WELCOME HERO ── */
        .hero-card {
            background: linear-gradient(135deg, #064E3B 0%, #065F46 60%, #047857 100%);
            border-radius: 20px; padding: 36px 40px;
            margin-bottom: 28px;
            display: flex; justify-content: space-between; align-items: center;
            border: 1px solid rgba(52,211,153,0.2);
            position: relative; overflow: hidden;
        }
        .hero-card::before {
            content: ''; position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(52,211,153,0.2) 0%, transparent 70%);
        }
        .hero-card::after {
            content: ''; position: absolute;
            bottom: -40px; right: 120px;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(52,211,153,0.1) 0%, transparent 70%);
        }
        .hero-text h2 { font-size: 26px; font-weight: 900; color: white; margin-bottom: 6px; letter-spacing: -0.5px; }
        .hero-text p { color: rgba(255,255,255,0.7); font-size: 14px; max-width: 400px; line-height: 1.6; }
        .hero-actions { display: flex; gap: 10px; margin-top: 20px; }
        .hero-btn {
            padding: 10px 22px; border-radius: 10px; font-size: 13px; font-weight: 700;
            text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        }
        .hero-btn.solid { background: white; color: #065F46; }
        .hero-btn.solid:hover { background: #F0FDF4; transform: translateY(-1px); }
        .hero-btn.outline { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.25); }
        .hero-btn.outline:hover { background: rgba(255,255,255,0.2); }
        .hero-emoji { font-size: 80px; position: relative; z-index: 1; }

        /* ── STATS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
        .stat-card {
            background: #0F172A; border: 1px solid #1E293B;
            border-radius: 16px; padding: 22px 24px;
            display: flex; align-items: center; gap: 16px;
            transition: all 0.2s;
        }
        .stat-card:hover { border-color: #334155; transform: translateY(-2px); }
        .stat-icon-wrap {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
        }
        .stat-icon-wrap.green { background: rgba(52,211,153,0.12); }
        .stat-icon-wrap.blue { background: rgba(96,165,250,0.12); }
        .stat-icon-wrap.yellow { background: rgba(251,191,36,0.12); }
        .stat-info .stat-label { font-size: 12px; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .stat-info .stat-val { font-size: 28px; font-weight: 800; color: #F1F5F9; }
        .stat-info .stat-sub { font-size: 12px; color: #64748B; margin-top: 2px; }

        /* ── SECTION HEADER ── */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .section-header h2 { font-size: 18px; font-weight: 800; color: #F1F5F9; }
        .section-header a { font-size: 13px; color: #34D399; text-decoration: none; font-weight: 600; }
        .section-header a:hover { text-decoration: underline; }

        /* ── OWNED PACKAGES ── */
        .owned-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; margin-bottom: 36px; }
        .owned-card {
            background: #0F172A; border: 1px solid #1E293B;
            border-radius: 16px; padding: 24px;
            transition: all 0.3s; position: relative; overflow: hidden;
        }
        .owned-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #34D399, #059669);
        }
        .owned-card:hover { border-color: rgba(52,211,153,0.3); transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .owned-card .card-icon { font-size: 36px; margin-bottom: 14px; }
        .owned-card h3 { font-size: 16px; font-weight: 700; color: #F1F5F9; margin-bottom: 6px; }
        .owned-card .card-desc { font-size: 13px; color: #64748B; line-height: 1.5; margin-bottom: 16px; }
        .owned-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(52,211,153,0.1); color: #34D399;
            border: 1px solid rgba(52,211,153,0.25);
            padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700;
        }

        /* ── AVAILABLE PACKAGES ── */
        .avail-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; margin-bottom: 36px; }
        .avail-card {
            background: #0F172A; border: 1px solid #1E293B;
            border-radius: 16px; padding: 24px;
            transition: all 0.3s; display: flex; flex-direction: column;
        }
        .avail-card:hover { border-color: #334155; transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .avail-card .card-icon { font-size: 36px; margin-bottom: 14px; }
        .avail-card h3 { font-size: 16px; font-weight: 700; color: #F1F5F9; margin-bottom: 6px; }
        .avail-card .card-desc { font-size: 13px; color: #64748B; line-height: 1.5; margin-bottom: 16px; flex-grow: 1; }
        .avail-card .card-price { font-size: 22px; font-weight: 800; color: #34D399; margin-bottom: 16px; }
        .btn-cart {
            width: 100%; padding: 11px; border-radius: 10px;
            background: rgba(52,211,153,0.1); color: #34D399;
            border: 1px solid rgba(52,211,153,0.25);
            font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-cart:hover { background: #34D399; color: #0F172A; border-color: #34D399; }

        /* ── PENDING ORDERS ── */
        .pending-list { display: flex; flex-direction: column; gap: 12px; margin-bottom: 36px; }
        .pending-card {
            background: #0F172A; border: 1px solid #1E293B;
            border-radius: 14px; padding: 18px 22px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .pending-card .order-info h4 { font-size: 14px; font-weight: 700; color: #F1F5F9; margin-bottom: 4px; }
        .pending-card .order-info p { font-size: 12px; color: #64748B; }
        .pending-card .order-right { text-align: right; flex-shrink: 0; }
        .pending-card .order-price { font-size: 16px; font-weight: 800; color: #F1F5F9; margin-bottom: 6px; }
        .badge-pending {
            display: inline-block; padding: 4px 12px; border-radius: 20px;
            background: rgba(251,191,36,0.12); color: #FBBF24;
            border: 1px solid rgba(251,191,36,0.25); font-size: 11px; font-weight: 700;
        }

        /* ── EMPTY STATE ── */
        .empty-box {
            background: #0F172A; border: 1px dashed #1E293B;
            border-radius: 16px; padding: 48px 24px;
            text-align: center; margin-bottom: 36px;
        }
        .empty-box .empty-icon { font-size: 48px; margin-bottom: 12px; }
        .empty-box p { color: #64748B; font-size: 14px; margin-bottom: 16px; }
        .btn-empty {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px; border-radius: 10px;
            background: #34D399; color: #0F172A;
            font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.2s;
        }
        .btn-empty:hover { background: #10B981; }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" alt="Logo">
        <span>PT KOMARI</span>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->full_name ?? auth()->user()->username, 0, 1)) }}
        </div>
        <div class="user-name">{{ auth()->user()->full_name ?? auth()->user()->username }}</div>
        <div class="user-role">{{ auth()->user()->email }}</div>
        <span class="user-badge">🎓 Siswa</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('dashboard') }}" class="nav-item active">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="{{ route('courses.index') }}" class="nav-item">
            <i class="fa-solid fa-book-open"></i> Semua Kursus
        </a>
        <a href="{{ route('cart.index') }}" class="nav-item">
            <i class="fa-solid fa-cart-shopping"></i> Keranjang
            @if($cartCount > 0)
                <span class="nav-badge">{{ $cartCount }}</span>
            @endif
        </a>

        <div class="nav-label">Transaksi</div>
        <a href="{{ route('orders.index') }}" class="nav-item">
            <i class="fa-solid fa-receipt"></i> Riwayat Pesanan
            @if($pendingOrders->count() > 0)
                <span class="nav-badge">{{ $pendingOrders->count() }}</span>
            @endif
        </a>

        <div class="nav-label">Lainnya</div>
        <a href="{{ route('home') }}" class="nav-item">
            <i class="fa-solid fa-globe"></i> Beranda
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-side">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- ── MAIN ── --}}
<div class="main">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="topbar-left">
            <h1>Dashboard Siswa</h1>
            <p>{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="topbar-right">
            <a href="{{ route('cart.index') }}" class="topbar-btn ghost">
                <i class="fa-solid fa-cart-shopping"></i>
                Keranjang
                @if($cartCount > 0)
                    <span style="background:#EF4444;color:white;font-size:10px;font-weight:700;padding:1px 6px;border-radius:20px;">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('courses.index') }}" class="topbar-btn primary">
                <i class="fa-solid fa-plus"></i> Tambah Paket
            </a>
        </div>
    </div>

    {{-- Content --}}
    <div class="content">

        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info"><i class="fa-solid fa-circle-info"></i> {{ session('info') }}</div>
        @endif
        @if(session('login_success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> Login berhasil! Selamat datang kembali 👋</div>
        @endif

        {{-- Hero --}}
        <div class="hero-card">
            <div class="hero-text">
                <h2>Halo, {{ auth()->user()->full_name ?? auth()->user()->username }}! 👋</h2>
                <p>Selamat datang di dashboard belajarmu. Kamu punya <strong style="color:white;">{{ $ownedPackages->count() }} paket aktif</strong>. Terus semangat belajar!</p>
                <div class="hero-actions">
                    <a href="{{ route('courses.index') }}" class="hero-btn solid">
                        <i class="fa-solid fa-magnifying-glass"></i> Jelajahi Kursus
                    </a>
                    <a href="{{ route('orders.index') }}" class="hero-btn outline">
                        <i class="fa-solid fa-receipt"></i> Riwayat Pesanan
                    </a>
                </div>
            </div>
            <div class="hero-emoji">🎓</div>
        </div>

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon-wrap green">📚</div>
                <div class="stat-info">
                    <div class="stat-label">Paket Aktif</div>
                    <div class="stat-val">{{ $ownedPackages->count() }}</div>
                    <div class="stat-sub">kursus dimiliki</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrap blue">🛒</div>
                <div class="stat-info">
                    <div class="stat-label">Di Keranjang</div>
                    <div class="stat-val">{{ $cartCount }}</div>
                    <div class="stat-sub">item belum checkout</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrap yellow">⏳</div>
                <div class="stat-info">
                    <div class="stat-label">Menunggu Bayar</div>
                    <div class="stat-val">{{ $pendingOrders->count() }}</div>
                    <div class="stat-sub">pesanan pending</div>
                </div>
            </div>
        </div>

        {{-- Pending Orders Warning --}}
        @if($pendingOrders->count() > 0)
            <div class="alert alert-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Kamu punya <strong>{{ $pendingOrders->count() }} pesanan</strong> yang menunggu konfirmasi pembayaran dari admin.
                <a href="{{ route('orders.index') }}" style="color:#FBBF24;margin-left:8px;font-weight:700;">Lihat →</a>
            </div>
        @endif

        {{-- Paket Saya --}}
        <div class="section-header">
            <h2>✅ Paket Belajar Saya</h2>
        </div>

        @if($ownedPackages->count() === 0)
            <div class="empty-box">
                <div class="empty-icon">📭</div>
                <p>Kamu belum punya paket aktif. Yuk beli paket pertamamu!</p>
                <a href="{{ route('courses.index') }}" class="btn-empty">
                    <i class="fa-solid fa-plus"></i> Lihat Kursus
                </a>
            </div>
        @else
            <div class="owned-grid">
                @foreach($ownedPackages as $pkg)
                    @php
                        $icons = ['Matematika'=>'📐','Bahasa Inggris'=>'🌍','IPA'=>'🔬','IPS'=>'🌏'];
                        $colors = ['Matematika'=>'#60A5FA','Bahasa Inggris'=>'#34D399','IPA'=>'#F87171','IPS'=>'#FBBF24'];
                        $icon = $icons[$pkg->name] ?? '📚';
                    @endphp
                    <div class="owned-card">
                        <div class="card-icon">{{ $icon }}</div>
                        <h3>{{ $pkg->name }}</h3>
                        <div class="card-desc">{{ $pkg->description ?? 'Paket belajar aktif.' }}</div>
                        <div class="owned-badge">
                            <i class="fa-solid fa-circle-check"></i> Sudah Dimiliki
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Paket Tersedia --}}
        @if($availablePackages->count() > 0)
            <div class="section-header">
                <h2>🛒 Paket Tersedia</h2>
                <a href="{{ route('courses.index') }}">Lihat semua →</a>
            </div>
            <div class="avail-grid">
                @foreach($availablePackages as $row)
                    @php
                        $icons = ['Matematika'=>'📐','Bahasa Inggris'=>'🌍','IPA'=>'🔬','IPS'=>'🌏'];
                        $icon = $icons[$row->name] ?? '📚';
                    @endphp
                    <div class="avail-card">
                        <div class="card-icon">{{ $icon }}</div>
                        <h3>{{ $row->name }}</h3>
                        <div class="card-desc">{{ $row->description ?? 'Tingkatkan kemampuanmu bersama mentor berpengalaman.' }}</div>
                        <div class="card-price">Rp {{ number_format($row->price, 0, ',', '.') }}</div>
                        <form action="{{ route('cart.add', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-cart">
                                <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Pesanan Pending --}}
        @if($pendingOrders->count() > 0)
            <div class="section-header">
                <h2>⏳ Pesanan Menunggu Konfirmasi</h2>
                <a href="{{ route('orders.index') }}">Lihat semua →</a>
            </div>
            <div class="pending-list">
                @foreach($pendingOrders as $order)
                    <div class="pending-card">
                        <div class="order-info">
                            <h4>Order #{{ $order->id }}</h4>
                            <p>
                                @foreach($order->orderItems as $item)
                                    {{ $item->course->name ?? '-' }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p style="margin-top:4px;">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="order-right">
                            <div class="order-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                            <span class="badge-pending">⏳ Menunggu Konfirmasi</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

</body>
</html>
