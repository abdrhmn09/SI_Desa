# SI Desa - Sistem Informasi Desa

Sistem Informasi Desa (SI Desa) adalah platform web untuk mengelola administrasi dan informasi Gampong Blang Kubu, Kecamatan Peudada, Kabupaten Bireuen, Aceh.

## Fitur Utama

### Portal Publik
- **Berita & Artikel** - Informasi terkini seputar desa
- **Galeri** - Dokumentasi foto kegiatan desa
- **Sejarah** - Riwayat kepemimpinan dan asal-usul desa
- **Tentang** - Informasi geografis, demografi, dan profil desa

### Admin Dashboard
- **Manajemen Pengguna** - Kelola user dan hak akses (role-based permission)
- **Kependudukan** - Data penduduk dan Kartu Keluarga (KK), termasuk import/export Excel
- **Surat Menyurat** - Pengajuan surat oleh penduduk, persetujuan admin, cetak surat
- **Artikel & Galeri** - Kelola konten website desa
- **Struktur Pemerintahan** - Data pejabat desa
- **Pengaturan** - Konfigurasi identitas desa

### Fitur Surat
- Penduduk memilih jenis surat → mengisi form → submit pengajuan
- Admin/Kades menyetujui atau menolak pengajuan
- Cetak surat dalam format resmi (PDF-ready)

## Tech Stack

- **Framework**: CodeIgniter 4
- **PHP**: ^8.2
- **Database**: MySQL
- **Libraries**: PHPSpreadsheet (untuk import/export Excel)

## Instalasi

### Prasyarat
- PHP 8.2 atau lebih tinggi
- MySQL/MariaDB
- Composer

### Langkah Instalasi

```bash
# Clone repository
git clone https://github.com/abdrhmn09/SI_Desa.git
cd SI_Desa

# Install dependencies
composer install

# Copy environment file
cp env .env

# Konfigurasi database di .env
# DB_DATABASE=nama_database
# DB_USERNAME=username
# DB_PASSWORD=password

# Jalankan migrasi
php spark migrate

# Jalankan seeder
php spark db:seed IdentitasDesaSeeder
php spark db:seed TemplateSuratSeeder

# Jalankan development server
php spark serve
```

Akses aplikasi di `http://localhost:8080`

## Struktur Direktori

```
app/
├── Config/          # Konfigurasi routing, filter, dll
├── Controllers/     # Logic aplikasi
├── Database/        # Migrations & Seeds
├── Models/          # Eloquent models
└── Views/           # Template HTML
    ├── auth/        # Login, register, forgot password
    ├── landing/     # Halaman publik
    ├── surat/       # Form dan cetak surat
    └── layout/      # Layout admin
```

## Hak Akses

| Fitur | Admin | Penduduk |
|-------|-------|----------|
| Kelola Pengguna | ✓ | - |
| Kelola Kependudukan | ✓ | - |
| Kelola Artikel | ✓ | - |
| Pengajuan Surat | ✓ | ✓ |
| Persetujuan Surat | ✓ | - |
| Riwayat Surat | ✓ | ✓ |
| Profil Mandiri | - | ✓ |

## License

MIT License
