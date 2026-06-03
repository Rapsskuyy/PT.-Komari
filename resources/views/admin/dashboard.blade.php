@extends('layouts.app')

@section('title', 'Admin Dashboard - PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .admin-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }

    /* Welcome bar */
    .welcome-bar {
        background: linear-gradient(135deg, #064E3B 0%, #065F46 50%, #047857 100%);
        border: 1px solid rgba(52,211,153,0.3);
        border-radius: 20px;
        padding: 32px 40px;
        margin-bottom: 36px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .welcome-bar h2 { font-size: 24px; font-weight: 800; color: white; margin-bottom: 4px; }
    .welcome-bar p { color: rgba(255,255,255,0.7); font-size: 14px; }
    .welcome-badge { background: rgba(255,255,255,0.15); color: white; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; border: 1px solid rgba(255,255,255,0.2); }

    /* Stats */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 36px; }
    .stat-card {
        background: #1E293B;
        padding: 28px;
        border-radius: 16px;
        border: 1px solid #334155;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }
    .stat-card.orders::before { background: #60A5FA; }
    .stat-card.revenue::before { background: #34D399; }
    .stat-card.pending::before { background: #FBBF24; }
    .stat-card.courses::before { background: #A78BFA; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
    .stat-card .icon { font-size: 28px; margin-bottom: 12px; }
    .stat-card .label { font-size: 13px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .stat-card .value { font-size: 32px; font-weight: 800; }
    .stat-card.orders .value { color: #60A5FA; }
    .stat-card.revenue .value { color: #34D399; font-size: 24px; }
    .stat-card.pending .value { color: #FBBF24; }
    .stat-card.courses .value { color: #A78BFA; }

    /* Quick actions */
    .actions-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 36px; }
    .action-card {
        background: #1E293B;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 28px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s;
    }
    .action-card:hover { transform: translateY(-4px); border-color: var(--accent); box-shadow: 0 8px 24px rgba(52,211,153,0.15); }
    .action-card .action-icon { font-size: 40px; flex-shrink: 0; }
    .action-card .action-text h3 { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 4px; }
    .action-card .action-text p { font-size: 13px; color: var(--text-muted); }
    .action-card .action-arrow { margin-left: auto; color: var(--text-muted); font-size: 20px; transition: transform 0.2s; }
    .action-card:hover .action-arrow { transform: translateX(4px); color: var(--accent); }

    /* Recent orders */
    .table-wrapper { background: #1E293B; border-radius: 16px; border: 1px solid #334155; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #334155; color: var(--text-main); }
    th { background: #0F172A; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(255,255,255,0.02); }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
    .status-pending { background: rgba(251,191,36,0.15); color: #FBBF24; border: 1px solid rgba(251,191,36,0.3); }
    .status-paid { background: rgba(52,211,153,0.15); color: #34D399; border: 1px solid rgba(52,211,153,0.3); }
    .table-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 20px 0; }
    .table-header h3 { font-size: 16px; font-weight: 700; color: var(--text-main); }
    .table-header a { font-size: 13px; color: var(--accent); text-decoration: none; }
    .table-header a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI — ADMIN</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('admin.courses') }}" class="btn-riwayat">Kursus</a>
        <a href="{{ route('admin.orders') }}" class="btn-riwayat">Pesanan</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>

<div class="admin-wrapper">

    {{-- Welcome --}}
    <div class="welcome-bar">
        <div>
            <h2>Selamat datang, {{ auth()->user()->full_name ?? auth()->user()->username }}! 👋</h2>
            <p>Berikut ringkasan aktivitas PT Komari hari ini.</p>
        </div>
        <span class="welcome-badge">🛡️ Administrator</span>
    </div>

    {{-- Stats --}}
    <h2 class="section-title">Ringkasan</h2>
    <div class="stats-grid">
        <div class="stat-card orders">
            <div class="icon">📦</div>
            <div class="label">Total Pesanan</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card revenue">
            <div class="icon">💰</div>
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card pending">
            <div class="icon">⏳</div>
            <div class="label">Menunggu Konfirmasi</div>
            <div class="value">{{ $pendingOrders }}</div>
        </div>
        <div class="stat-card courses">
            <div class="icon">📚</div>
            <div class="label">Total Kursus</div>
            <div class="value">{{ $totalCourses }}</div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <h2 class="section-title">Menu Utama</h2>
    <div class="actions-grid">
        <a href="{{ route('admin.courses') }}" class="action-card">
            <div class="action-icon">📚</div>
            <div class="action-text">
                <h3>Kelola Kursus</h3>
                <p>Tambah, edit, atau hapus paket kursus yang tersedia</p>
            </div>
            <span class="action-arrow">→</span>
        </a>
        <a href="{{ route('admin.orders') }}" class="action-card">
            <div class="action-icon">📦</div>
            <div class="action-text">
                <h3>Kelola Pesanan</h3>
                <p>Konfirmasi pembayaran dan kelola status pesanan siswa</p>
            </div>
            <span class="action-arrow">→</span>
        </a>
    </div>

    {{-- Recent Orders --}}
    <div class="table-header">
        <h3>Pesanan Terbaru</h3>
        <a href="{{ route('admin.orders') }}">Lihat semua →</a>
    </div>
    <div class="table-wrapper" style="margin-top: 12px;">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td style="font-weight: 700; color: var(--accent);">#{{ $order->id }}</td>
                        <td>{{ $order->user->full_name ?? $order->user->username }}</td>
                        <td style="font-weight: 700;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ $order->status === 'pending' ? '⏳ Pending' : '✅ Lunas' }}
                            </span>
                        </td>
                        <td style="font-size: 13px; color: var(--text-muted);">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 32px; color: var(--text-muted);">
                            Belum ada pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
