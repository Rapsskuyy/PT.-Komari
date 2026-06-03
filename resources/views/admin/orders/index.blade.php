@extends('layouts.app')

@section('title', 'Kelola Pesanan - Admin PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .admin-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 8px; letter-spacing: -1px; }
    .section-sub { color: var(--text-muted); font-size: 14px; margin-bottom: 28px; }

    /* Filter tabs */
    .filter-tabs { display: flex; gap: 8px; margin-bottom: 24px; }
    .filter-tab { padding: 8px 20px; border-radius: 20px; border: 1px solid #334155; background: transparent; color: var(--text-muted); font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .filter-tab:hover, .filter-tab.active { background: var(--accent); color: #0F172A; border-color: var(--accent); }
    .filter-tab.pending-tab.active { background: #FBBF24; border-color: #FBBF24; color: #0F172A; }
    .filter-tab.paid-tab.active { background: #34D399; border-color: #34D399; color: #0F172A; }

    .table-wrapper { background: #1E293B; border-radius: 16px; border: 1px solid #334155; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #334155; color: var(--text-main); }
    th { background: #0F172A; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(255,255,255,0.02); }

    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
    .status-pending { background: rgba(251,191,36,0.15); color: #FBBF24; border: 1px solid rgba(251,191,36,0.3); }
    .status-paid { background: rgba(52,211,153,0.15); color: #34D399; border: 1px solid rgba(52,211,153,0.3); }

    .btn-sm { padding: 6px 14px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 12px; transition: all 0.2s; }
    .btn-approve { background: rgba(52,211,153,0.15); color: #34D399; border: 1px solid rgba(52,211,153,0.3); }
    .btn-approve:hover { background: #34D399; color: #0F172A; }
    .btn-reject { background: rgba(239,68,68,0.15); color: #F87171; border: 1px solid rgba(239,68,68,0.3); }
    .btn-reject:hover { background: #EF4444; color: white; }

    .course-list { display: flex; flex-direction: column; gap: 2px; }
    .course-tag { font-size: 12px; color: var(--text-muted); }

    .alert-msg { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
    .alert-success { background: rgba(52,211,153,0.15); color: #34D399; border: 1px solid rgba(52,211,153,0.3); }

    .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
    .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
</style>
@endpush

@section('content')
<nav class="navbar">
    <div class="nav-left">
        <img src="{{ asset('pic/pt.komari-removebg-preview-removebg-preview.png') }}" class="nav-logo" alt="Logo PT Komari" />
        <span>PT KOMARI — ADMIN</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('admin.dashboard') }}" class="btn-riwayat">Dashboard</a>
        <a href="{{ route('admin.courses') }}" class="btn-riwayat">Kursus</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>

<div class="admin-wrapper">

    @if(session('success'))
        <div class="alert-msg alert-success">✅ {{ session('success') }}</div>
    @endif

    <h2 class="section-title">📦 Kelola Pesanan</h2>
    <p class="section-sub">Total {{ $orders->count() }} pesanan —
        {{ $orders->where('status','pending')->count() }} pending,
        {{ $orders->where('status','paid')->count() }} lunas
    </p>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Kursus</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-weight: 700; color: var(--accent);">#{{ $order->id }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $order->user->full_name ?? $order->user->username }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ $order->user->email }}</div>
                        </td>
                        <td>
                            <div class="course-list">
                                @foreach($order->orderItems as $item)
                                    <span class="course-tag">• {{ $item->course->name ?? 'Kursus dihapus' }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td style="font-weight: 700; color: var(--text-main);">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ $order->status === 'pending' ? '⏳ Pending' : '✅ Lunas' }}
                            </span>
                        </td>
                        <td style="font-size: 13px; color: var(--text-muted);">
                            {{ $order->created_at->format('d M Y') }}<br>
                            <span style="font-size: 11px;">{{ $order->created_at->format('H:i') }}</span>
                        </td>
                        <td>
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="btn-sm btn-approve">✅ Konfirmasi Bayar</button>
                                </form>
                            @else
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" style="display: inline;"
                                    onsubmit="return confirm('Reset status ke pending?')">
                                    @csrf
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="btn-sm btn-reject">↩️ Reset</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>Belum ada pesanan masuk.</p>
                            </div>
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
