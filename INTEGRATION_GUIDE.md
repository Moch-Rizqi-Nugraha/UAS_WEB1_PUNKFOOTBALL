# Punk Football - User & Admin Integration Guide

## Overview
Panduan lengkap integrasi fitur User dengan Admin dalam aplikasi Punk Football.

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     PUNK FOOTBALL APP                       │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────┐           ┌──────────────────────┐   │
│  │   USER FEATURES  │           │  ADMIN FEATURES      │   │
│  ├──────────────────┤           ├──────────────────────┤   │
│  │ • Dashboard      │◄─────────►│ • Dashboard          │   │
│  │ • Events         │           │ • Event Management   │   │
│  │ • Tickets        │           │ • User Management    │   │
│  │ • Marketplace    │           │ • Ticket Management  │   │
│  │ • Profile        │           │ • Transaction Log    │   │
│  └──────────────────┘           │ • Reports            │   │
│         ▲                        └──────────────────────┘   │
│         │                                  ▲                │
│         │                                  │                │
│    [Database Models & Relationships]       │                │
│         │                                  │                │
│         ▼                                  ▼                │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              SHARED DATA MODELS                      │  │
│  ├──────────────────────────────────────────────────────┤  │
│  │ • User (Role: admin/user)                           │  │
│  │ • Event ◄─────► EventParticipant ◄─────► User      │  │
│  │ • Ticket ◄─────► Event & User                       │  │
│  │ • Transaction ◄─────► User & Product               │  │
│  │ • Product                                            │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 1. EVENTS MANAGEMENT

### User Side (UserController)
- **Dashboard**: Tampilkan upcoming events, confirmed events, completed events
- **View Events**: List semua event yang diikuti user dengan status
- **Join Event**: User bisa bergabung event (POST `/user/events/{event}/join`)
- **Leave Event**: User bisa meninggalkan event jika belum dimulai

### Admin Side (Admin/EventController)
- **Manage Events**: CRUD events
- **Participants Management**: Lihat, approve, atau remove peserta
- **Status Tracking**: Track participant status (registered → confirmed → completed)
- **Event Analytics**: Stats tentang participants, availability

### Database Relations
```
Event
├── hasMany EventParticipant
├── hasMany Ticket
└── Methods:
    ├── participants() - all participants
    ├── confirmedParticipants() - only confirmed
    ├── hasAvailableSpots() - check availability
    └── getAvailableSpots() - get remaining spots

EventParticipant
├── belongsTo Event
├── belongsTo User
└── Fields:
    ├── status (registered/confirmed/completed/cancelled)
    ├── registered_at
    └── updated_at

User
├── hasMany EventParticipant
├── registeredEvents() - with scope
└── confirmedEvents() - with scope
```

### Routes Integration
```php
// User Routes
POST   /user/events/{event}/join           - Join event
POST   /user/events/{event}/leave          - Leave event
GET    /user/events                        - View my events

// Admin Routes
GET    /admin/events                       - List all events
POST   /admin/events                       - Create event
PATCH  /admin/events/{event}               - Update event
DELETE /admin/events/{event}               - Delete event
PATCH  /admin/events/{event}/toggle-status - Toggle status
PATCH  /admin/events/{event}/participants/{participant} - Update participant
```

---

## 2. TICKETS SYSTEM

### User Side (UserController)
- **Buy Tickets**: User bisa membeli tiket untuk event
- **View Tickets**: Lihat semua tiket yang sudah dibeli dengan status
- **Ticket Stats**: Total tiket, total harga, dan status breakdown

### Admin Side (Admin/TicketController)
- **Generate Tickets**: Admin buat tiket untuk event
- **Track Status**: Monitor tiket (available/used/expired)
- **User Tickets**: Lihat tiket per user
- **Event Tickets**: Lihat tiket per event
- **Mark As Used**: Mark tiket sebagai sudah digunakan

### Database Relations
```
Ticket
├── belongsTo User
├── belongsTo Event
└── Fields:
    ├── ticket_number (unique)
    ├── price
    ├── status (available/used/expired/cancelled)
    ├── purchase_date
    └── used_at

User
└── hasMany Ticket

Event
└── hasMany Ticket
```

### Routes Integration
```php
// User Routes
POST   /user/events/{event}/buy-ticket     - Buy tickets
GET    /user/tickets                       - View my tickets

// Admin Routes
GET    /admin/tickets                      - List all tickets
POST   /admin/tickets                      - Create tickets
PATCH  /admin/tickets/{ticket}             - Update ticket
DELETE /admin/tickets/{ticket}             - Delete ticket
GET    /admin/tickets/event/{event}        - Event tickets
GET    /admin/tickets/user/{user}          - User tickets
PATCH  /admin/tickets/{ticket}/mark-used   - Mark ticket as used
```

---

## 3. MARKETPLACE SYSTEM

### User Side (MarketplaceController)
- **Browse Products**: Lihat semua produk marketplace
- **Buy Products**: Beli produk dan create transaction
- **View Purchases**: Lihat semua purchase history dengan status

### Admin Side (Admin/MarketplaceController)
- **Product Management**: CRUD products
- **Transaction Tracking**: Monitor semua transaksi user
- **Stock Management**: Track product stock
- **Sales Analytics**: Revenue, pending sales, completed sales
- **User Transactions**: Lihat transaction history per user

### Database Relations
```
Product
├── hasMany Transaction
└── Fields:
    ├── name
    ├── description
    ├── price
    ├── stock
    ├── category
    └── image

Transaction
├── belongsTo User
├── belongsTo Product
└── Fields:
    ├── transaction_type (purchase/payment)
    ├── amount
    ├── status (pending/completed/cancelled)
    ├── transaction_date
    └── transaction_data (json)

User
└── hasMany Transaction
```

### Routes Integration
```php
// User Routes
GET    /marketplace                        - Browse products
POST   /marketplace/{id}/buy                - Buy product

// Admin Routes
GET    /admin/marketplace                  - List transactions
POST   /admin/marketplace                  - Create product/transaction
PATCH  /admin/marketplace/{id}             - Update transaction
GET    /admin/marketplace/user/{user}      - User transactions
GET    /admin/marketplace/product/{product} - Product sales
PATCH  /admin/marketplace/{id}/status      - Update status
```

---

## 4. USER MANAGEMENT

### Admin Side (Admin/UserController)
- **View Users**: Semua user dengan search dan filter
- **User Details**: Lihat dashboard user dengan all activities
- **User Activities**: View events, tickets, transactions
- **Update User Role**: Ubah role user (admin/user/moderator)
- **Activity Tracking**: See recent activities dari setiap user

### Routes Integration
```php
// Admin Routes
GET    /admin/users                        - List users
GET    /admin/users/{user}                 - View user details
PATCH  /admin/users/{user}                 - Update user
GET    /admin/users/{user}/events          - User events
GET    /admin/users/{user}/tickets         - User tickets
GET    /admin/users/{user}/transactions    - User transactions
PATCH  /admin/users/{user}/event-participation/{participation} - Update event status
DELETE /admin/users/{user}/event-participation/{participation} - Remove from event
```

---

## 5. ADMIN DASHBOARD

### Features
- **Real-time Stats**: Total users, events, tickets, transactions
- **Recent Activities**: Last 5 users, events, tickets, transactions
- **Revenue Analytics**: Ticket revenue, marketplace revenue, pending
- **Activity Trends**: Daily user signups, transaction trends (last 7 days)

### Data Displayed
```
Dashboard Stats:
├── Users
│   ├── Total Users
│   ├── Total Admins
│   └── Total Regular Users
├── Events
│   ├── Total Events
│   ├── Active Events
│   └── Total Participants
├── Tickets
│   ├── Total Tickets Sold
│   ├── Available Tickets
│   ├── Used Tickets
│   └── Ticket Revenue
└── Marketplace
    ├── Total Products
    ├── Total Transactions
    ├── Completed Sales
    └── Pending Sales
```

---

## 6. DATA FLOW EXAMPLES

### Example 1: User Joins Event & Buys Ticket
```
User Dashboard
    ↓
User clicks "Join Event" (EventParticipant created with status='registered')
    ↓
Admin can see new participant in Event details
    ↓
User wants to buy ticket (clicks "Buy Ticket")
    ↓
Ticket created (status='available')
    ↓
Transaction created (status='completed')
    ↓
Admin can see in:
    - Tickets dashboard
    - User transactions
    - Event ticket sales
    - Dashboard reports
```

### Example 2: Admin Approves Event Participants
```
Admin views Event details
    ↓
See registered participants (status='registered')
    ↓
Admin approves all pending
    ↓
EventParticipant status changes to 'confirmed'
    ↓
User sees confirmed status in their events list
    ↓
After event completes, admin marks as 'completed'
    ↓
User sees in completed events
```

### Example 3: Admin Tracks User Activity
```
Admin goes to User details page
    ↓
See user statistics:
    - Events joined (count & list)
    - Tickets purchased (count & list)
    - Transactions (count & total spent)
    ↓
Can click through to:
    - All user's events with status
    - All user's tickets
    - All user's transactions
    ↓
Can perform actions:
    - Update event participation status
    - Remove user from event
    - View transaction details
```

---

## 7. KEY INTEGRATION POINTS

### Middleware
- `CheckAdminRole`: Verifikasi admin access
- `CheckUserRole`: Verifikasi user access

### Models Used
1. **User**: Core user model dengan role
2. **Event**: Event management
3. **EventParticipant**: Pivot table untuk user-event relationship
4. **Ticket**: Ticket untuk events
5. **Product**: Marketplace products
6. **Transaction**: Purchase/payment transactions

### Controllers
- **User Side**: UserController, MarketplaceController
- **Admin Side**: 
  - Admin/UserController - manage users
  - Admin/EventController - manage events
  - Admin/TicketController - manage tickets
  - Admin/MarketplaceController - manage marketplace
  - Admin/DashboardController - analytics

---

## 8. IMPLEMENTATION CHECKLIST

- ✅ UserController: Complete dengan all methods
- ✅ Routes: User routes updated dengan join/leave/buy-ticket
- ✅ Admin/UserController: Extended dengan activity tracking
- ✅ Admin/EventController: Full CRUD dengan participant management
- ✅ Admin/TicketController: Comprehensive ticket management
- ✅ Admin/MarketplaceController: Full marketplace tracking
- ✅ Admin/DashboardController: Real-time analytics
- ✅ Middleware: CheckAdminRole & CheckUserRole
- ⏳ Views: Perlu update untuk menggunakan new controller methods
- ⏳ API Routes: Optional untuk mobile/third-party integration

---

## 9. TESTING CHECKLIST

### User Features
- [ ] User dapat join event
- [ ] User dapat leave event sebelum dimulai
- [ ] User dapat buy tickets
- [ ] User dapat see all events/tickets/transactions
- [ ] User dashboard menampilkan data real

### Admin Features
- [ ] Admin dapat lihat semua users
- [ ] Admin dapat lihat user activity details
- [ ] Admin dapat manage events (CRUD)
- [ ] Admin dapat manage participants
- [ ] Admin dapat manage tickets
- [ ] Admin dapat manage marketplace
- [ ] Admin dashboard menampilkan real stats
- [ ] Admin dapat update statuses

### Data Integration
- [ ] Event participants sync dengan user's events
- [ ] Tickets sync dengan transactions
- [ ] Transaction amounts match product prices
- [ ] User activity reflects immediately di admin

---

## 10. NEXT STEPS

1. **Update Views**: Modify Blade templates untuk use new methods
2. **Add Tests**: Write feature tests untuk semua user-admin interactions
3. **API Integration**: Create API routes untuk mobile app (optional)
4. **Notifications**: Add email/SMS notifications saat status changes
5. **Reports**: Create PDF/Excel export untuk reports
6. **Audit Log**: Track semua admin actions ke audit table
7. **Permission System**: Implement more granular permissions (spatie/laravel-permission)

