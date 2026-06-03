# 📸 Export Diagram ke PNG

## Cara Paling Mudah: Mermaid Live Editor

### 1. ERD Diagram
Buka: https://mermaid.live/

Copy & paste code ini:
```
erDiagram
    USERS ||--o{ ORDERS : places
    USERS ||--o{ CARTS : has
    USERS ||--o{ RATINGS : gives
    COURSES ||--o{ ORDER_ITEMS : contains
    COURSES ||--o{ CARTS : in
    COURSES ||--o{ RATINGS : receives
    ORDERS ||--o{ ORDER_ITEMS : has

    USERS {
        bigint id PK
        string username UK
        string full_name
        string email UK
        string password
        enum role "user, admin"
        timestamp created_at
        timestamp updated_at
    }

    COURSES {
        bigint id PK
        string name
        text description
        decimal price
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    ORDERS {
        bigint id PK
        bigint user_id FK
        decimal total_price
        enum status "pending, paid"
        timestamp created_at
        timestamp updated_at
    }

    ORDER_ITEMS {
        bigint id PK
        bigint order_id FK
        bigint course_id FK
        decimal price
        timestamp created_at
        timestamp updated_at
    }

    CARTS {
        bigint id PK
        bigint user_id FK
        bigint course_id FK
        integer quantity
        timestamp created_at
        timestamp updated_at
    }

    RATINGS {
        bigint id PK
        bigint user_id FK
        bigint course_id FK
        integer rating "1-5"
        text review
        timestamp created_at
        timestamp updated_at
    }
```

Klik **Download PNG** → Save sebagai `ERD_PT_Komari.png`

---

### 2. Flowchart Lengkap
Buka: https://mermaid.live/

Copy & paste code ini:
```
flowchart TB
    Start([Buka Website PT Komari]) --> Guest{User Status}
    
    %% === GUEST SECTION ===
    Guest -->|Belum Login| RegisterLogin{Pilih Action}
    RegisterLogin -->|Register| RegForm[Isi Form Register:<br/>- Nama Lengkap<br/>- Username<br/>- Email<br/>- Password<br/>- Konfirmasi Password]
    RegForm --> RegValidate{Validasi Data}
    RegValidate -->|Invalid<br/>Username/Email exist| RegError[Tampil Error]
    RegError --> RegForm
    RegValidate -->|Valid| CreateUser[Buat User Baru<br/>role: user]
    CreateUser --> AutoLogin[Auto Login]
    
    RegisterLogin -->|Login| LoginForm[Isi Username & Password]
    LoginForm --> LoginValidate{Cek Kredensial}
    LoginValidate -->|Salah| LoginError[Tampil Error:<br/>Username/Password Salah]
    LoginError --> LoginForm
    
    %% === ROLE CHECK ===
    Guest -->|Sudah Login| CheckRole{Cek Role User}
    AutoLogin --> CheckRole
    LoginValidate -->|Benar| CheckRole
    
    CheckRole -->|role = admin| AdminDash[Dashboard Admin]
    CheckRole -->|role = user| SiswaDash[Dashboard Siswa]
    
    %% === ADMIN FLOW ===
    AdminDash --> AdminMenu{Pilih Menu}
    AdminMenu -->|View Stats| ViewStats[Lihat Statistik:<br/>- Total Pesanan<br/>- Total Pendapatan<br/>- Pending Orders<br/>- Total Kursus]
    ViewStats --> AdminMenu
    
    AdminMenu -->|Kelola Kursus| CourseManage[Halaman Kelola Kursus]
    CourseManage --> CourseCRUD{Aksi Kursus}
    CourseCRUD -->|Tambah| AddCourse[Isi Form:<br/>- Nama<br/>- Harga<br/>- Deskripsi<br/>- Status]
    AddCourse --> SaveCourse[Simpan ke DB]
    SaveCourse --> CourseManage
    
    CourseCRUD -->|Edit| EditCourse[Update Data Kursus]
    EditCourse --> SaveCourse
    
    CourseCRUD -->|Hapus| DeleteCourse[Hapus Kursus]
    DeleteCourse --> CourseManage
    
    CourseCRUD -->|Kembali| AdminMenu
    
    AdminMenu -->|Kelola Pesanan| OrderManage[Halaman Kelola Pesanan]
    OrderManage --> ViewOrders[Lihat Semua Pesanan]
    ViewOrders --> FilterOrder{Filter}
    FilterOrder -->|All| ShowAll[Tampil Semua]
    FilterOrder -->|Pending| ShowPending[Tampil Pending Saja]
    FilterOrder -->|Paid| ShowPaid[Tampil Paid Saja]
    
    ShowAll --> OrderAction{Pilih Pesanan}
    ShowPending --> OrderAction
    ShowPaid --> OrderAction
    
    OrderAction -->|Detail| ViewOrderDetail[Lihat Detail:<br/>- Info Pelanggan<br/>- Item Pesanan<br/>- Total Harga]
    ViewOrderDetail --> OrderAction
    
    OrderAction -->|Konfirmasi| ConfirmPayment{Status Saat Ini?}
    ConfirmPayment -->|Pending| UpdateToPaid[Update status: paid<br/>Siswa bisa akses paket]
    UpdateToPaid --> OrderManage
    
    ConfirmPayment -->|Paid| ResetToPending[Reset status: pending]
    ResetToPending --> OrderManage
    
    OrderAction -->|Kembali| AdminMenu
    
    AdminMenu -->|Logout| Logout[Logout & Clear Session]
    
    %% === SISWA FLOW ===
    SiswaDash --> SiswaView[Tampil Dashboard:<br/>- Hero Card<br/>- 3 Stat Card<br/>- Paket Saya<br/>- Paket Tersedia<br/>- Pesanan Pending]
    SiswaView --> SiswaMenu{Pilih Action}
    
    SiswaMenu -->|Lihat Paket Saya| ViewOwned[Tampil Paket<br/>yang Sudah Dibeli<br/>status: paid]
    ViewOwned --> SiswaMenu
    
    SiswaMenu -->|Tambah Paket| ViewAvailable[Lihat Paket Tersedia]
    ViewAvailable --> SelectCourse{Pilih Paket}
    
    SelectCourse -->|Dari Dashboard| AddFromDash[Klik Tambah ke Keranjang]
    SelectCourse -->|Lihat Detail| CourseDetail[Halaman Detail Kursus]
    CourseDetail --> CourseDetailAction{Action}
    CourseDetailAction -->|Tambah| AddFromDetail[Klik Tambah ke Keranjang]
    CourseDetailAction -->|Rating| GiveRating[Isi Rating 1-5<br/>+ Review opsional]
    GiveRating --> SaveRating[Simpan Rating ke DB]
    SaveRating --> CourseDetail
    
    AddFromDash --> CheckCart{Cek Cart}
    AddFromDetail --> CheckCart
    
    CheckCart -->|Sudah Ada| CartExists[Tampil Info:<br/>Paket sudah di keranjang]
    CartExists --> SiswaMenu
    
    CheckCart -->|Belum Ada| AddToCart[Tambah ke Cart DB]
    AddToCart --> CartAdded[Notifikasi Success]
    CartAdded --> ContinueShopping{Lanjut Belanja?}
    ContinueShopping -->|Ya| ViewAvailable
    ContinueShopping -->|Tidak| SiswaMenu
    
    SiswaMenu -->|Lihat Keranjang| OpenCart[Buka Halaman Keranjang]
    OpenCart --> CartEmpty{Keranjang Kosong?}
    CartEmpty -->|Ya| EmptyCart[Tampil: Keranjang Kosong]
    EmptyCart --> SiswaMenu
    
    CartEmpty -->|Tidak| ShowCart[Tampil Item:<br/>- Nama Kursus<br/>- Harga<br/>- Total]
    ShowCart --> CartAction{Action di Cart}
    
    CartAction -->|Hapus Item| RemoveItem[Hapus dari Cart DB]
    RemoveItem --> ShowCart
    
    CartAction -->|Checkout| ConfirmPage[Halaman Konfirmasi Pesanan]
    ConfirmPage --> ReviewOrder[Review:<br/>- Semua Item<br/>- Total Harga]
    ReviewOrder --> SubmitOrder{Buat Pesanan?}
    SubmitOrder -->|Batal| OpenCart
    
    SubmitOrder -->|Ya| CreateOrder[Proses Transaksi:<br/>1. Buat Order pending<br/>2. Buat Order Items<br/>3. Kosongkan Cart]
    CreateOrder --> OrderCreated[Redirect ke Detail Order]
    OrderCreated --> ShowOrderDetail[Tampil:<br/>- Order ID<br/>- Status: Pending<br/>- Menunggu Konfirmasi]
    ShowOrderDetail --> SiswaMenu
    
    SiswaMenu -->|Riwayat Pesanan| ViewHistory[Lihat Semua Pesanan]
    ViewHistory --> HistoryList[List Order:<br/>- Order ID<br/>- Items<br/>- Total<br/>- Status<br/>- Tanggal]
    HistoryList --> HistoryAction{Action}
    HistoryAction -->|Detail| ViewHistoryDetail[Detail Pesanan]
    ViewHistoryDetail --> HistoryList
    HistoryAction -->|Kembali| SiswaMenu
    
    SiswaMenu -->|Logout| Logout
    
    %% === END ===
    Logout --> End([Kembali ke Halaman Login])
    
    %% === STYLING ===
    classDef adminStyle fill:#fbbf24,stroke:#f59e0b,stroke-width:2px,color:#000
    classDef siswaStyle fill:#34d399,stroke:#10b981,stroke-width:2px,color:#000
    classDef processStyle fill:#60a5fa,stroke:#3b82f6,stroke-width:2px,color:#000
    classDef errorStyle fill:#f87171,stroke:#ef4444,stroke-width:2px,color:#000
    classDef successStyle fill:#86efac,stroke:#22c55e,stroke-width:2px,color:#000
    
    class AdminDash,AdminMenu,ViewStats,CourseManage,OrderManage adminStyle
    class SiswaDash,SiswaView,SiswaMenu,ViewOwned siswaStyle
    class CreateOrder,SaveCourse,UpdateToPaid,AddToCart processStyle
    class RegError,LoginError,CartExists errorStyle
    class OrderCreated,CartAdded,CreateUser successStyle
```

Klik **Download PNG** → Save sebagai `Flowchart_PT_Komari.png`

---

### 3. Use Case Diagram
Buka: https://mermaid.live/

Copy & paste code ini:
```
graph TB
    subgraph Siswa
        S1[Register Akun]
        S2[Login]
        S3[Lihat Kursus]
        S4[Tambah ke Keranjang]
        S5[Checkout]
        S6[Lihat Riwayat Pesanan]
        S7[Beri Rating Kursus]
    end
    
    subgraph Admin
        A1[Login Admin]
        A2[Lihat Dashboard Stats]
        A3[Kelola Kursus]
        A4[Tambah Kursus]
        A5[Edit Kursus]
        A6[Hapus Kursus]
        A7[Kelola Pesanan]
        A8[Konfirmasi Pembayaran]
    end
    
    SISWA((Siswa)) --> S1
    SISWA --> S2
    SISWA --> S3
    SISWA --> S4
    SISWA --> S5
    SISWA --> S6
    SISWA --> S7
    
    ADMIN((Admin)) --> A1
    ADMIN --> A2
    ADMIN --> A3
    ADMIN --> A4
    ADMIN --> A5
    ADMIN --> A6
    ADMIN --> A7
    ADMIN --> A8
```

Klik **Download PNG** → Save sebagai `UseCase_PT_Komari.png`

---

### 4. Architecture Diagram
Buka: https://mermaid.live/

Copy & paste code ini:
```
graph TB
    subgraph Client
        B[Browser]
    end
    
    subgraph Laravel Application
        R[Routes web.php]
        M[Middleware: auth, admin]
        
        subgraph Controllers
            AC[AuthController]
            DC[DashboardController]
            CC[CourseController]
            CartC[CartController]
            OC[OrderController]
            AdminC[AdminController]
            RC[RatingController]
        end
        
        subgraph Models
            U[User]
            C[Course]
            O[Order]
            OI[OrderItem]
            Cart[Cart]
            Rat[Rating]
        end
        
        subgraph Views
            Auth[auth/*.blade.php]
            Dash[dashboard.blade.php]
            Courses[courses/*.blade.php]
            Orders[orders/*.blade.php]
            Admin[admin/*.blade.php]
        end
    end
    
    subgraph Database
        SQLite[(SQLite DB)]
    end
    
    B <-->|HTTP Request/Response| R
    R --> M
    M --> AC & DC & CC & CartC & OC & AdminC & RC
    
    AC & DC & CC & CartC & OC & AdminC & RC --> U & C & O & OI & Cart & Rat
    U & C & O & OI & Cart & Rat <--> SQLite
    
    AC & DC & CC & CartC & OC & AdminC & RC --> Auth & Dash & Courses & Orders & Admin
    Auth & Dash & Courses & Orders & Admin --> B
```

Klik **Download PNG** → Save sebagai `Architecture_PT_Komari.png`

---

## 📁 Hasil Akhir

Setelah download semua, Anda akan punya:
- ✅ `ERD_PT_Komari.png`
- ✅ `Flowchart_PT_Komari.png`
- ✅ `UseCase_PT_Komari.png`
- ✅ `Architecture_PT_Komari.png`

Simpan di folder `docs/` atau `images/` dalam project Anda!
