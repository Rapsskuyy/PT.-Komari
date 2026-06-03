@extends('layouts.app')

@section('title', 'Kelola Kursus - Admin PT Komari')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .admin-wrapper { padding: 40px 80px; max-width: 1200px; margin: 0 auto; }
    .section-title { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
    .table-wrapper { background: #1E293B; border-radius: 16px; border: 1px solid #334155; overflow: hidden; margin-bottom: 40px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 16px; text-align: left; border-bottom: 1px solid #334155; color: var(--text-main); }
    th { background: #0F172A; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(255,255,255,0.02); }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
    .status-active { background: rgba(52, 211, 153, 0.15); color: #34D399; border: 1px solid rgba(52,211,153,0.3); }
    .status-inactive { background: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239,68,68,0.3); }
    .btn-sm { padding: 6px 14px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 12px; transition: all 0.2s; }
    .btn-edit { background: rgba(59,130,246,0.15); color: #60A5FA; border: 1px solid rgba(59,130,246,0.3); }
    .btn-edit:hover { background: #3B82F6; color: white; }
    .btn-delete { background: rgba(239,68,68,0.15); color: #F87171; border: 1px solid rgba(239,68,68,0.3); }
    .btn-delete:hover { background: #EF4444; color: white; }
    .btn-toggle { background: rgba(251,191,36,0.15); color: #FBBF24; border: 1px solid rgba(251,191,36,0.3); }
    .btn-toggle:hover { background: #FBBF24; color: #0F172A; }

    /* Form card */
    .form-card { background: #1E293B; padding: 28px; border-radius: 16px; border: 1px solid #334155; margin-bottom: 32px; }
    .form-card h3 { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: 13px; color: var(--text-muted); font-weight: 600; }
    .form-group input, .form-group textarea, .form-group select {
        padding: 10px 14px; border-radius: 10px; border: 1px solid #334155;
        background: #0F172A; color: var(--text-main); font-size: 14px;
        transition: border-color 0.2s;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
        outline: none; border-color: var(--accent);
    }
    .form-group textarea { resize: vertical; min-height: 80px; }
    .btn-submit { background: var(--accent); color: #0F172A; padding: 10px 24px; border-radius: 10px; border: none; cursor: pointer; font-weight: 700; font-size: 14px; transition: all 0.2s; margin-top: 4px; }
    .btn-submit:hover { background: var(--accent-hover); transform: translateY(-1px); }
    .btn-cancel { background: #334155; color: var(--text-muted); padding: 10px 24px; border-radius: 10px; border: none; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s; margin-top: 4px; margin-left: 8px; }
    .btn-cancel:hover { background: #475569; color: var(--text-main); }

    /* Modal overlay for edit */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 200; align-items: center; justify-content: center; }
    .modal-overlay.active { display: flex; }
    .modal-box { background: #1E293B; border-radius: 20px; border: 1px solid #334155; padding: 32px; width: 100%; max-width: 560px; }
    .modal-box h3 { font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: 24px; }

    .alert-msg { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
    .alert-success { background: rgba(52,211,153,0.15); color: #34D399; border: 1px solid rgba(52,211,153,0.3); }
    .alert-error { background: rgba(239,68,68,0.15); color: #F87171; border: 1px solid rgba(239,68,68,0.3); }
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
        <a href="{{ route('admin.orders') }}" class="btn-riwayat">Pesanan</a>
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
    @if($errors->any())
        <div class="alert-msg alert-error">❌ {{ $errors->first() }}</div>
    @endif

    <h2 class="section-title">📚 Kelola Kursus</h2>

    {{-- FORM TAMBAH KURSUS --}}
    <div class="form-card">
        <h3>➕ Tambah Kursus Baru</h3>
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Kursus *</label>
                    <input type="text" name="name" placeholder="Contoh: Matematika" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" placeholder="Contoh: 300000" required value="{{ old('price') }}">
                </div>
                <div class="form-group full">
                    <label>Deskripsi</label>
                    <textarea name="description" placeholder="Deskripsi singkat kursus...">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div class="form-group" style="justify-content: flex-end; flex-direction: row; align-items: flex-end;">
                    <button type="submit" class="btn-submit">Tambah Kursus</button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABEL KURSUS --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kursus</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td style="color: var(--text-muted); font-size: 13px;">{{ $course->id }}</td>
                        <td style="font-weight: 700;">{{ $course->name }}</td>
                        <td style="color: var(--text-muted); font-size: 13px; max-width: 200px;">
                            {{ Str::limit($course->description, 60) ?? '-' }}
                        </td>
                        <td style="color: var(--accent); font-weight: 700;">
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="status-badge {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $course->is_active ? '● Aktif' : '● Nonaktif' }}
                            </span>
                        </td>
                        <td style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <button class="btn-sm btn-edit"
                                onclick="openEditModal({{ $course->id }}, '{{ addslashes($course->name) }}', {{ $course->price }}, '{{ addslashes($course->description ?? '') }}', {{ $course->is_active ? 1 : 0 }})">
                                ✏️ Edit
                            </button>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Hapus kursus {{ addslashes($course->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            Belum ada kursus. Tambahkan kursus pertama di atas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <h3>✏️ Edit Kursus</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div class="form-group">
                    <label>Nama Kursus *</label>
                    <input type="text" name="name" id="edit_name" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" id="edit_price" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" id="edit_is_active">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div style="display: flex; gap: 8px; margin-top: 8px;">
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
<script>
function openEditModal(id, name, price, description, isActive) {
    document.getElementById('editForm').action = '/admin/courses/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_is_active').value = isActive;
    document.getElementById('editModal').classList.add('active');
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endpush
