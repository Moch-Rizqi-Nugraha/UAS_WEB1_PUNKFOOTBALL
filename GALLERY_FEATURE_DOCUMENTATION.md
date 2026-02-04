# Dokumentasi Fitur Galeri - Punk Football

## Ringkasan

Fitur galeri telah berhasil ditambahkan ke platform Punk Football. Fitur ini memungkinkan admin mengunggah dan mengelola galeri foto, serta menampilkan galeri ke pengguna di berbagai halaman.

## Komponen yang Ditambahkan

### 1. Model Gallery (`app/Models/Gallery.php`)
- **Fields**: 
  - `title` - Judul galeri
  - `description` - Deskripsi galeri
  - `image` - Path ke file gambar
  - `image_alt` - Teks alt untuk aksesibilitas
  - `category` - Kategori galeri
  - `order` - Urutan tampilan
  - `is_active` - Status aktif/nonaktif
  - `created_by` - User yang membuat
  - `timestamps` - Tanggal buat dan perbarui

- **Methods**:
  - `scopeActive()` - Filter galeri yang aktif
  - `scopeByCategory()` - Filter berdasarkan kategori
  - `getCategories()` - Ambil daftar kategori unik
  - `creator()` - Relasi ke user yang membuat

### 2. Migration (`database/migrations/2026_01_26_000001_create_galleries_table.php`)
Membuat tabel `galleries` dengan struktur yang sesuai

### 3. Controllers

#### Admin Gallery Controller (`app/Http/Controllers/Admin/GalleryController.php`)
Menangani operasi CRUD untuk admin:
- `index()` - Menampilkan daftar galeri
- `create()` - Form untuk tambah galeri
- `store()` - Simpan galeri baru
- `edit()` - Form edit galeri
- `update()` - Update galeri
- `destroy()` - Hapus galeri
- `toggleStatus()` - Ubah status aktif/nonaktif
- `reorder()` - Mengurutkan galeri
- `filterByCategory()` - Filter berdasarkan kategori

#### Public Gallery Controller (`app/Http/Controllers/GalleryController.php`)
Menangani tampilan publik:
- `index()` - Tampilkan semua galeri aktif
- `byCategory()` - Filter berdasarkan kategori
- `show()` - Tampilkan detail galeri
- `getDashboardGalleries()` - Ambil galeri untuk dashboard

### 4. Views

#### Admin Views (`resources/views/admin/galleries/`)
- **index.blade.php** - Daftar galeri dengan filter kategori dan grid display
- **create.blade.php** - Form tambah galeri dengan preview gambar
- **edit.blade.php** - Form edit galeri
- **show.blade.php** - Detail galeri

#### Public Views (`resources/views/galleries/`)
- **index.blade.php** - Halaman galeri publik dengan filter kategori dan pagination
- **show.blade.php** - Detail galeri dengan gambar besar dan galeri terkait

#### Component (`resources/views/components/gallery-widget.blade.php`)
Widget galeri yang dapat digunakan di berbagai halaman

### 5. Routes

#### Admin Routes
```php
Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
```

#### Public Routes
```php
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/category/{category}', [GalleryController::class, 'byCategory'])->name('galleries.category');
Route::get('/galleries/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');
```

## Fitur Utama

### Untuk Admin:
1. **Upload Gambar**: Upload gambar dengan format JPG, PNG, GIF, WebP (max 5MB)
2. **Kelola Kategori**: Buat kategori baru atau pilih kategori yang ada
3. **Metadata**: Judul, deskripsi, teks alt untuk aksesibilitas
4. **Urutan**: Tentukan urutan tampilan galeri
5. **Status**: Aktifkan/nonaktifkan galeri
6. **Filter**: Filter galeri berdasarkan kategori
7. **Edit/Hapus**: Ubah atau hapus galeri yang sudah ada

### Untuk User:
1. **Lihat Galeri**: Lihat galeri di halaman publik atau dashboard
2. **Detail Galeri**: Klik gambar untuk melihat detail lengkap
3. **Filter Kategori**: Filter galeri berdasarkan kategori
4. **Galeri Terkait**: Lihat galeri dengan kategori yang sama
5. **Responsive**: Tampilan yang responsif di semua perangkat

## Integrasi di Dashboard

### Welcome Page (`resources/views/welcome.blade.php`)
- Bagian "Galeri Acara Kami" menampilkan 8 galeri terbaru
- Tombol "Lihat Selengkapnya" ke halaman galeri lengkap
- Desain grid yang menarik dengan hover effect

### User Dashboard (`resources/views/user/dashboard.blade.php`)
- Widget galeri menampilkan 8 galeri terbaru
- Tombol ke halaman galeri lengkap
- Integrasi dengan quick actions lainnya

## Instruksi Penggunaan

### Untuk Admin:

1. **Tambah Galeri Baru**:
   - Masuk ke Admin Panel
   - Pilih menu "Galeri" atau "Manajemen Galeri"
   - Klik tombol "+ Tambah Galeri"
   - Isi form dan upload gambar
   - Klik "Simpan Galeri"

2. **Edit Galeri**:
   - Dari daftar galeri, klik tombol "Edit"
   - Ubah data yang diperlukan
   - Upload gambar baru jika diperlukan
   - Klik "Update Galeri"

3. **Hapus Galeri**:
   - Dari daftar galeri, klik tombol "Hapus"
   - Konfirmasi penghapusan

4. **Filter Kategori**:
   - Pilih kategori dari dropdown
   - Klik "Filter"
   - Daftar akan diperbarui

5. **Ubah Status**:
   - Klik badge status (Aktif/Nonaktif) untuk mengubah status
   - Status akan tersimpan otomatis

### Untuk User:

1. **Lihat Galeri**:
   - Dari welcome page, scroll ke bagian "Galeri Acara Kami"
   - Atau klik link "Galeri" di navigasi
   - Klik gambar untuk melihat detail

2. **Filter Kategori**:
   - Di halaman galeri, klik kategori yang diinginkan
   - Atau klik "Semua" untuk melihat semua galeri

3. **Lihat Detail**:
   - Klik pada gambar galeri
   - Lihat deskripsi lengkap dan metadata
   - Lihat galeri terkait di bawah

## Database Migration

Untuk menjalankan migration:

```bash
php artisan migrate
```

Perintah ini akan membuat tabel `galleries` dengan kolom-kolom yang diperlukan.

## File Storage

Gambar galeri disimpan di:
```
storage/app/public/galleries/
```

Pastikan folder ini dapat diakses dengan menjalankan:
```bash
php artisan storage:link
```

## Catatan Teknis

1. **Soft Delete**: Dapat diimplementasikan di masa depan untuk keep history
2. **Image Optimization**: Gambar di-store dengan nama unik untuk menghindari konfllik
3. **Pagination**: Daftar galeri di paginate 12 item per halaman
4. **Security**: Admin hanya dapat mengelola galeri mereka sendiri
5. **Query Optimization**: Menggunakan eager loading untuk relasi

## Future Enhancements

1. **Image Compression**: Kompres gambar otomatis saat upload
2. **Album Feature**: Kelompokkan galeri ke dalam album
3. **Tagging**: Tambahkan tag untuk galeri
4. **User Permissions**: Kontrol akses per user
5. **Advanced Filters**: Filter berdasarkan tanggal, creator, dll
6. **Gallery API**: Endpoint API untuk integrasi pihak ketiga
7. **Lightbox**: Lightbox view untuk galeri

## Troubleshooting

### Gambar tidak tampil:
- Pastikan `storage/public` sudah di-link dengan `php artisan storage:link`
- Periksa permission folder `storage/app/public/galleries`

### Admin panel tidak menampilkan galeri menu:
- Pastikan user memiliki role admin
- Clear cache dengan `php artisan cache:clear`

### Pagination tidak bekerja:
- Periksa `.env` untuk pagination settings
- Pastikan lebih dari 12 galeri di database

## Kontak & Support

Untuk pertanyaan atau issues, silakan hubungi tim development.
