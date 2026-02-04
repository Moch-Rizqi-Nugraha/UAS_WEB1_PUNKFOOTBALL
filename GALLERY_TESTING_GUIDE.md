# Testing Guide - Fitur Galeri

## Quick Start Testing

### Prasyarat:
- ✅ Database sudah di-migrate
- ✅ Storage sudah di-link
- ✅ User sudah login sebagai admin

---

## Test Case 1: Admin Tambah Galeri

**Tujuan**: Memverifikasi admin dapat menambah galeri baru

**Steps**:
1. Login sebagai admin
2. Navigasi ke `/admin/galleries`
3. Klik tombol "+ Tambah Galeri"
4. Isi form:
   - Title: "Pertandingan Seru di Stadion X"
   - Description: "Momen seru dari pertandingan final liga lokal"
   - Category: "Pertandingan" (atau ketik kategori baru)
   - Order: 0
   - Image: Upload foto
   - Alt Text: "Para pemain saling rebut bola"
   - Status: Centang "Aktifkan Galeri"
5. Klik "Simpan Galeri"

**Expected Result**:
- ✅ Muncul flash message "Galeri berhasil ditambahkan"
- ✅ Halaman kembali ke `/admin/galleries`
- ✅ Galeri baru muncul di daftar

**Troubleshoot jika gagal**:
- Cek apakah file image valid (JPG, PNG, GIF, WebP)
- Cek ukuran file (max 5MB)
- Cek folder `storage/app/public/galleries` memiliki permission write

---

## Test Case 2: Admin Edit Galeri

**Tujuan**: Memverifikasi admin dapat edit galeri

**Steps**:
1. Dari daftar galeri, klik tombol "Edit" pada galeri yang baru dibuat
2. Ubah title menjadi: "Pertandingan Seru di Stadion X (Updated)"
3. Ubah order menjadi: 1
4. Klik "Update Galeri"

**Expected Result**:
- ✅ Muncul flash message "Galeri berhasil diperbarui"
- ✅ Daftar galeri ter-update
- ✅ Title berubah di daftar

---

## Test Case 3: Admin Filter Kategori

**Tujuan**: Memverifikasi filter kategori berfungsi

**Steps**:
1. Di halaman `/admin/galleries`
2. Pilih kategori dari dropdown
3. Klik tombol "Filter"

**Expected Result**:
- ✅ Daftar galeri ter-filter sesuai kategori
- ✅ Hanya galeri dengan kategori yang dipilih ditampilkan

---

## Test Case 4: Admin Hapus Galeri

**Tujuan**: Memverifikasi admin dapat menghapus galeri

**Steps**:
1. Dari daftar galeri, klik tombol "Hapus"
2. Klik OK pada dialog konfirmasi

**Expected Result**:
- ✅ Muncul flash message "Galeri berhasil dihapus"
- ✅ Galeri hilang dari daftar
- ✅ File gambar terhapus dari storage

---

## Test Case 5: Admin Lihat Detail Galeri

**Tujuan**: Memverifikasi halaman detail galeri

**Steps**:
1. Dari daftar galeri, klik tombol "Lihat"

**Expected Result**:
- ✅ Halaman detail galeri terbuka
- ✅ Menampilkan gambar, judul, deskripsi, metadata
- ✅ Tersedia tombol Edit, Hapus, Kembali

---

## Test Case 6: User Lihat Galeri di Welcome Page

**Tujuan**: Memverifikasi galeri muncul di welcome page

**Steps**:
1. Logout atau buka di incognito tab
2. Ke halaman `/` (welcome page)
3. Scroll ke bagian "Galeri Acara Kami"

**Expected Result**:
- ✅ Galeri ditampilkan dalam grid 4 kolom
- ✅ Hanya galeri aktif (is_active=true) yang tampil
- ✅ Maksimal 8 galeri ditampilkan
- ✅ Tombol "Lihat Selengkapnya" tersedia jika ada galeri
- ✅ Hover effect berfungsi

---

## Test Case 7: User Lihat Galeri di User Dashboard

**Tujuan**: Memverifikasi galeri muncul di user dashboard

**Steps**:
1. Login sebagai user (non-admin)
2. Ke halaman `/user/dashboard`
3. Scroll ke bawah

**Expected Result**:
- ✅ Widget "Galeri Acara" tampil
- ✅ Menampilkan maksimal 8 galeri aktif
- ✅ Tombol "Lihat Semua Galeri" tersedia
- ✅ Responsive di mobile

---

## Test Case 8: User Lihat Halaman Galeri Lengkap

**Tujuan**: Memverifikasi halaman `/galleries` berfungsi

**Steps**:
1. Klik "Lihat Semua Galeri" dari welcome atau user dashboard
2. Atau langsung ke `/galleries`

**Expected Result**:
- ✅ Halaman galeri publik terbuka
- ✅ Filter kategori tersedia
- ✅ Grid galeri ditampilkan (4 kolom di desktop, 2 di tablet, 1 di mobile)
- ✅ Pagination berfungsi

---

## Test Case 9: User Filter Galeri Berdasarkan Kategori

**Tujuan**: Memverifikasi filter kategori di halaman publik

**Steps**:
1. Di halaman `/galleries`
2. Klik salah satu kategori

**Expected Result**:
- ✅ URL berubah ke `/galleries/category/{category}`
- ✅ Daftar galeri ter-filter sesuai kategori
- ✅ Tombol kategori yang dipilih highlight

---

## Test Case 10: User Lihat Detail Galeri

**Tujuan**: Memverifikasi halaman detail galeri publik

**Steps**:
1. Dari halaman galeri, klik salah satu gambar
2. Atau direct URL: `/galleries/{id}`

**Expected Result**:
- ✅ Halaman detail terbuka
- ✅ Menampilkan gambar besar
- ✅ Judul, deskripsi, metadata tampil
- ✅ Galeri terkait ditampilkan di bawah
- ✅ Tombol "Kembali ke Galeri" berfungsi

---

## Test Case 11: Responsive Design Testing

**Tujuan**: Memverifikasi responsive design

**Steps**:
1. Buka halaman galeri (`/galleries`) di desktop
2. Resize browser ke ukuran tablet (768px)
3. Resize browser ke ukuran mobile (375px)

**Expected Result**:
- ✅ Desktop: Grid 4 kolom
- ✅ Tablet: Grid 2-3 kolom
- ✅ Mobile: Grid 1 kolom
- ✅ Semua elemen responsive dan mudah diklik

---

## Test Case 12: Image Upload Validation

**Tujuan**: Memverifikasi validasi file upload

**Steps**:
1. Di form tambah galeri
2. Coba upload file yang bukan gambar (txt, pdf, etc)

**Expected Result**:
- ❌ Upload ditolak dengan error message

**Steps 2**:
1. Coba upload file gambar > 5MB

**Expected Result**:
- ❌ Upload ditolak dengan error message

---

## Test Case 13: Status Active/Inactive

**Tujuan**: Memverifikasi status galeri

**Steps**:
1. Di admin galeri list, ada galeri dengan status "Aktif"
2. Perhatikan galeri tersebut di halaman publik
3. Nonaktifkan galeri (ubah status menjadi "Nonaktif")
4. Refresh halaman publik

**Expected Result**:
- ✅ Galeri aktif tampil di halaman publik
- ✅ Galeri nonaktif TIDAK tampil di halaman publik
- ✅ Galeri nonaktif masih tampil di admin

---

## Test Case 14: Category Management

**Tujuan**: Memverifikasi manajemen kategori

**Steps**:
1. Buat 3 galeri dengan kategori berbeda:
   - "Pertandingan"
   - "Latihan"
   - "Undian"
2. Di halaman admin galeri, filter setiap kategori
3. Di halaman publik galeri, filter setiap kategori

**Expected Result**:
- ✅ Semua kategori tersedia
- ✅ Filter menampilkan galeri sesuai kategori
- ✅ Total galeri sesuai dengan filter

---

## Test Case 15: Pagination

**Tujuan**: Memverifikasi pagination berfungsi

**Prasyarat**: Minimal 13 galeri aktif di database

**Steps**:
1. Di halaman publik `/galleries`
2. Lihat halaman 1 (12 galeri)
3. Klik halaman 2 pada pagination

**Expected Result**:
- ✅ Halaman 1 menampilkan 12 galeri
- ✅ Klik halaman 2 menampilkan galeri sisa
- ✅ URL berubah dengan query parameter page

---

## Performance Testing

**Tujuan**: Memverifikasi performa

**Steps**:
1. Buat 100 galeri aktif
2. Buka halaman `/galleries`
3. Check page load time dan response time

**Expected Result**:
- ✅ Page load < 3 detik
- ✅ Pagination bekerja smooth

---

## SQL Queries untuk Testing

```sql
-- Lihat semua galeri
SELECT * FROM galleries;

-- Lihat galeri aktif
SELECT * FROM galleries WHERE is_active = 1;

-- Lihat galeri berdasarkan kategori
SELECT * FROM galleries WHERE category = 'Pertandingan';

-- Hitung total galeri
SELECT COUNT(*) FROM galleries;

-- Lihat urutan galeri
SELECT id, title, `order`, category FROM galleries ORDER BY `order`, created_at DESC;
```

---

## Browser Compatibility Testing

Test di browser berikut:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Chrome
- [ ] Mobile Safari

---

## Issues & Resolutions

### Issue: Gambar tidak tampil
**Solution**:
1. Jalankan: `php artisan storage:link`
2. Check folder permissions: `chmod -R 775 storage/app/public`
3. Cek di database apakah path tersimpan dengan benar

### Issue: Upload error "Not an image"
**Solution**:
- Check apakah file benar-benar gambar
- Try upload dengan format lain (JPG vs PNG)

### Issue: Filter kategori tidak bekerja
**Solution**:
- Check database apakah kategori tersimpan
- Clear cache: `php artisan cache:clear`

### Issue: Pagination tidak tampil
**Solution**:
- Pastikan ada lebih dari 12 galeri aktif
- Check pagination config di `config/view.php`

---

## Checklist Implementasi Selesai

- [x] Database migration berjalan
- [x] Admin dapat membuat galeri
- [x] Admin dapat edit galeri
- [x] Admin dapat hapus galeri
- [x] Admin dapat filter kategori
- [x] User dapat lihat galeri di welcome page
- [x] User dapat lihat galeri di user dashboard
- [x] User dapat lihat halaman galeri lengkap
- [x] User dapat filter kategori
- [x] User dapat lihat detail galeri
- [x] Status aktif/nonaktif berfungsi
- [x] Image validation berfungsi
- [x] Responsive design berfungsi
- [x] Pagination berfungsi

---

## Dokumentasi Lengkap

Lihat:
- `GALLERY_FEATURE_DOCUMENTATION.md` - Dokumentasi fitur lengkap
- `GALLERY_IMPLEMENTATION_SUMMARY.md` - Ringkasan implementasi
