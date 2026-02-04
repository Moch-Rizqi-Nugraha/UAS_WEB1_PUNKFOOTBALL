# QUICK REFERENCE - FITUR GALERI

## 🚀 Quick Start (5 menit)

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Link Storage
```bash
php artisan storage:link
```

### 3. Access Admin Gallery
```
URL: /admin/galleries
```

### 4. Add First Gallery
- Click "+ Tambah Galeri"
- Fill form fields
- Upload image
- Click "Simpan Galeri"

### 5. View Gallery
- Welcome page: Scroll to "Galeri Acara Kami"
- User dashboard: Scroll to "Galeri Acara" section
- Public page: Visit `/galleries`

---

## 📁 File Structure

```
app/Models/
└── Gallery.php                    # Model with relations & scopes

app/Http/Controllers/
├── Admin/GalleryController.php    # Admin CRUD
└── GalleryController.php          # Public gallery

database/migrations/
└── 2026_01_26_000001_create_galleries_table.php

resources/views/
├── admin/galleries/               # 4 admin views
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── galleries/                     # 2 public views
│   ├── index.blade.php
│   └── show.blade.php
└── components/
    └── gallery-widget.blade.php   # Reusable component
```

---

## 🔗 Routes Quick Map

```
ADMIN ROUTES:
GET    /admin/galleries              → List galleries
POST   /admin/galleries              → Create gallery
GET    /admin/galleries/create       → Create form
GET    /admin/galleries/{id}         → Show gallery
GET    /admin/galleries/{id}/edit    → Edit form
PUT    /admin/galleries/{id}         → Update gallery
DELETE /admin/galleries/{id}         → Delete gallery

PUBLIC ROUTES:
GET    /galleries                    → List all galleries
GET    /galleries/category/{cat}     → Filter by category
GET    /galleries/{id}               → Show gallery detail
```

---

## 💾 Database Fields

```sql
id              BIGINT PRIMARY KEY
title           VARCHAR(255) NOT NULL
description     TEXT NULL
image           VARCHAR(255) NOT NULL
image_alt       VARCHAR(255) NULL
category        VARCHAR(255) NULL
order           INT DEFAULT 0
is_active       BOOLEAN DEFAULT 1
created_by      BIGINT NULL (FK: users)
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

---

## 🎨 Key Features

### Admin Side:
- ✅ Upload image (JPG, PNG, GIF, WebP, max 5MB)
- ✅ Real-time preview
- ✅ Category management
- ✅ Ordering system
- ✅ Active/Inactive toggle
- ✅ Full CRUD
- ✅ Filter by category
- ✅ Pagination (12/page)

### User Side:
- ✅ View on homepage
- ✅ View on dashboard
- ✅ Public gallery page
- ✅ Category filtering
- ✅ Detail view
- ✅ Related galleries
- ✅ Responsive design

---

## 📝 Common Tasks

### Admin Add Gallery
```
1. Go to /admin/galleries
2. Click "+ Tambah Galeri"
3. Fill: title*, image*, category, description, order
4. Click "Simpan Galeri"
```

### Admin Edit Gallery
```
1. Go to /admin/galleries
2. Click "Edit" button
3. Update fields
4. Click "Update Galeri"
```

### Admin Delete Gallery
```
1. Go to /admin/galleries
2. Click "Hapus" button
3. Confirm deletion
```

### Admin Filter by Category
```
1. Go to /admin/galleries
2. Select category
3. Click "Filter"
```

### View Gallery Public
```
Option 1: Homepage → scroll to "Galeri Acara Kami"
Option 2: /galleries
Option 3: User Dashboard → "Galeri Acara" widget
```

---

## 🛠️ Troubleshooting Quick Tips

| Issue | Solution |
|-------|----------|
| Image not showing | Run `php artisan storage:link` |
| Upload fails | Check file format & size (max 5MB) |
| Galleries not visible | Check `is_active = 1` in DB |
| Filter not working | Ensure galleries have category value |
| Database error | Run `php artisan migrate` |
| 404 on routes | Check `routes/web.php` has gallery routes |

---

## 📊 Database Queries

### Get all galleries
```sql
SELECT * FROM galleries;
```

### Get active galleries
```sql
SELECT * FROM galleries WHERE is_active = 1;
```

### Get by category
```sql
SELECT * FROM galleries WHERE category = 'Pertandingan' AND is_active = 1;
```

### Count galleries
```sql
SELECT COUNT(*) FROM galleries;
```

### Get ordered galleries
```sql
SELECT * FROM galleries WHERE is_active = 1 ORDER BY `order`, created_at DESC;
```

---

## 🔑 Key Model Methods

```php
// Get active galleries
Gallery::active()->get()

// Get by category
Gallery::byCategory('Pertandingan')->get()

// Get unique categories
Gallery::getCategories()

// Get dashboard galleries (first 8 active)
Gallery::active()->limit(8)->get()

// Get with creator info
Gallery::with('creator')->get()
```

---

## 📱 Responsive Breakpoints

- Mobile: 375px - grid 1 column
- Tablet: 768px - grid 2 columns
- Desktop: 1024px - grid 3-4 columns
- Large: 1280px+ - grid 4 columns

---

## 🔒 Security Notes

- Input validation on all forms
- File type validation (images only)
- File size validation (max 5MB)
- Auth required for admin
- Authorization checks
- XSS & CSRF protection

---

## ⚡ Performance Notes

- Database indexes on category, is_active, order
- Pagination for large lists (12 per page)
- Query optimization with scopes
- Eager loading for relations
- Optimized image storage

---

## 📚 Full Documentation Files

1. **GALLERY_FEATURE_DOCUMENTATION.md** - Complete feature docs
2. **GALLERY_IMPLEMENTATION_SUMMARY.md** - Implementation details
3. **GALLERY_TESTING_GUIDE.md** - 15+ test cases
4. **GALLERY_IMPLEMENTATION_CHECKLIST.md** - Completion checklist
5. **GALLERY_FEATURE_COMPLETION_REPORT.md** - Final report

---

## 🔄 Common Workflows

### Workflow 1: Add & Display Gallery
```
1. Admin login → /admin/galleries
2. Click "+ Tambah Galeri"
3. Fill form & upload
4. Save
5. Gallery appears on:
   - Homepage (automatic)
   - User dashboard (automatic)
   - /galleries page
```

### Workflow 2: Update Gallery
```
1. Admin → /admin/galleries
2. Find gallery → Click "Edit"
3. Update fields
4. Save
5. Changes visible immediately
```

### Workflow 3: User View Gallery
```
1. Homepage → scroll to gallery section
2. Click on image → detail page
3. See full info & related galleries
4. Or visit /galleries for full list
```

---

## 📋 Implementation Dates

- Start: 26 Januari 2026
- Completion: 26 Januari 2026
- Status: ✅ COMPLETE

---

## ✅ Pre-Launch Checklist

- [ ] Run `php artisan migrate`
- [ ] Run `php artisan storage:link`
- [ ] Test admin add gallery
- [ ] Test gallery display on homepage
- [ ] Test gallery display on dashboard
- [ ] Test /galleries page
- [ ] Test category filter
- [ ] Test on mobile device
- [ ] Check image storage permissions
- [ ] Clear cache if needed

---

## 📞 Support

For issues, refer to:
- **GALLERY_TESTING_GUIDE.md** → Troubleshooting section
- **GALLERY_FEATURE_DOCUMENTATION.md** → Full details

---

**Version**: 1.0
**Status**: ✅ Production Ready
**Last Updated**: 26 Januari 2026
