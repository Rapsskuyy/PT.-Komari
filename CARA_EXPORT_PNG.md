# 📸 CARA EXPORT DIAGRAM KE PNG - Step by Step

## 🎯 Metode Paling Mudah: Mermaid Live Editor

### Step 1: Buka Website
```
https://mermaid.live/
```

### Step 2: Buka File FLOWCHART_ERD.md
Di VS Code atau text editor, buka file `FLOWCHART_ERD.md`

### Step 3: Copy Diagram Code

#### Untuk ERD:
1. Cari section: `## 🗄️ ERD (Entity Relationship Diagram)`
2. Copy semua yang di dalam blok ` ```mermaid ... ``` `
3. **JANGAN copy** kata `mermaid` dan backtick (```)
4. Copy dari `erDiagram` sampai baris terakhir

#### Untuk Flowchart:
1. Cari section: `## 🔄 FLOWCHART LENGKAP`
2. Copy dari `flowchart TB` sampai baris terakhir

### Step 4: Paste ke Mermaid Live
1. Klik di area editor (sebelah kiri)
2. **Delete** semua code yang ada
3. **Paste** code yang sudah di-copy
4. Diagram otomatis muncul di kanan

### Step 5: Download PNG
1. Lihat pojok kanan atas
2. Klik icon **"Actions"** (3 titik vertikal)
3. Pilih **"PNG"**
4. File otomatis download

### Step 6: Rename File
Rename file yang di-download:
- `diagram-export-xxx.png` → `ERD_PT_Komari.png`
- atau → `Flowchart_PT_Komari.png`

---

## 🖥️ Alternatif: VS Code (Jika Punya Extension)

### Install Extension:
1. Buka VS Code
2. Tekan `Ctrl+Shift+X`
3. Search: **"Markdown Preview Mermaid Support"**
4. Klik **Install**

### Export:
1. Buka file `FLOWCHART_ERD.md`
2. Tekan `Ctrl+Shift+V` (Preview)
3. Klik kanan pada diagram
4. **"Save Image"** atau **Screenshot**

---

## 📱 Alternatif: Screenshot

Jika cara di atas ribet:

### Dari Mermaid Live:
1. Buka diagram di https://mermaid.live/
2. Zoom out agar diagram full (Ctrl + scroll mouse)
3. Screenshot (Windows: Win+Shift+S, Mac: Cmd+Shift+4)
4. Crop dan save

### Dari GitHub (Jika sudah push):
1. Push project ke GitHub
2. Buka file `FLOWCHART_ERD.md` di GitHub
3. Diagram otomatis ter-render
4. Screenshot

---

## 🎨 Tips Kualitas Tinggi

### Untuk Presentasi/Dokumentasi:
1. **Format:** Pilih **SVG** bukan PNG (scalable, tidak blur)
2. **Ukuran:** Zoom out untuk lihat full diagram
3. **Background:** Pilih background putih

### Untuk Laporan:
1. **Format:** PNG dengan resolusi tinggi
2. **Edit:** Bisa edit di Paint/Photoshop untuk tambah title

---

## 📋 Checklist

- [ ] Buka https://mermaid.live/
- [ ] Copy code ERD dari FLOWCHART_ERD.md
- [ ] Paste & download PNG (ERD_PT_Komari.png)
- [ ] Copy code Flowchart dari FLOWCHART_ERD.md
- [ ] Paste & download PNG (Flowchart_PT_Komari.png)
- [ ] Copy code Use Case (opsional)
- [ ] Copy code Architecture (opsional)
- [ ] Simpan semua PNG di folder `docs/images/`

---

## ❓ Troubleshooting

### Diagram tidak muncul?
- Pastikan copy code TANPA backtick (```)
- Pastikan tidak ada kata `mermaid` di awal
- Cek apakah ada error syntax (merah di Mermaid Live)

### Download tidak jalan?
- Coba browser lain (Chrome recommended)
- Atau screenshot saja

### Diagram terlalu besar?
- Zoom out di browser (Ctrl + Minus)
- Atau download SVG dan buka di browser untuk screenshot

---

## 🚀 Quick Links

- **Mermaid Live Editor:** https://mermaid.live/
- **Mermaid Docs:** https://mermaid.js.org/
- **VS Code Extension:** Search "Mermaid" di Extensions

---

**Selesai!** Anda sekarang punya file PNG untuk semua diagram 🎉
