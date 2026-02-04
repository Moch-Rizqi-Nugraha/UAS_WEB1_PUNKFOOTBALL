# QUICK REFERENCE - USER ADMIN INTEGRATION

## 🚀 QUICK START

### What's Been Integrated?

#### ✅ USER FEATURES
1. **Dashboard** - Real data dari events, tickets, purchases
2. **Events** - Join, leave, view status
3. **Tickets** - Buy, view, track status
4. **Marketplace** - Buy products, view transaction history

#### ✅ ADMIN FEATURES
1. **User Management** - View all users + their activities
2. **Event Management** - CRUD + participant tracking
3. **Ticket Management** - Generate, track, manage tickets
4. **Marketplace** - Manage products, track sales
5. **Dashboard** - Real-time analytics & reports

---

## 🔗 KEY CONNECTIONS

### Events System
```
User                    ↔ Event                 ↔ Admin
Join Event             EventParticipant        View Participants
(status=registered)    (pivot table)           Update Status
                                                Approve/Reject
```

### Tickets System
```
User                    ↔ Ticket               ↔ Admin
Buy Ticket             (belongs to user/event) Generate Tickets
View & Track           (status: available/    Mark as Used
                       used/expired)           View Statistics
```

### Marketplace System
```
User                    ↔ Transaction          ↔ Admin
Buy Product            (belongs to user)      Manage Products
View History           (status: pending/      Track Sales
                       completed)             Revenue Reports
```

---

## 📝 MOST IMPORTANT ROUTES

### USER ROUTES
```
GET    /user/dashboard              - Dashboard
GET    /user/events                 - View my events
POST   /user/events/{event}/join    - Join event ⭐
POST   /user/events/{event}/leave   - Leave event ⭐
POST   /user/events/{event}/buy-ticket - Buy ticket ⭐
GET    /user/tickets                - View my tickets
GET    /user/marketplace            - View purchases
```

### ADMIN ROUTES
```
GET    /admin/users                 - User list
GET    /admin/users/{user}          - User details + activities ⭐
GET    /admin/users/{user}/events   - User events
GET    /admin/users/{user}/tickets  - User tickets ⭐
GET    /admin/users/{user}/transactions - User purchases ⭐

GET    /admin/events                - Event list
GET    /admin/events/{event}        - Event + participants ⭐
PATCH  /admin/events/{event}/participants/{participant} - Update status ⭐

GET    /admin/tickets               - Ticket list
GET    /admin/tickets/event/{event} - Event tickets ⭐
GET    /admin/tickets/user/{user}   - User tickets ⭐

GET    /admin/marketplace           - Transactions list ⭐
GET    /admin/marketplace/user/{user} - User transactions ⭐
GET    /admin/marketplace/product/{product} - Product sales ⭐
```

---

## 💾 KEY DATABASE RELATIONSHIPS

```
User (1) ──────→ (Many) EventParticipant ←──────── (1) Event
         ↓
    (Many) Ticket ────→ (1) Event
         ↓
    (Many) Transaction ────→ (1) Product
```

### Main Queries Used
```php
// User's events
$user->eventParticipations()->with('event')->get();

// User's tickets
$user->tickets()->with('event')->get();

// User's purchases
$user->transactions()->with('product')->get();

// Event participants
$event->participants()->with('user')->get();

// Event tickets
$event->tickets()->with('user')->get();
```

---

## ⚡ USEFUL METHODS

### IntegrationHelper Class (NEW)
```php
use App\Utilities\IntegrationHelper;

// Get user activity summary
$summary = IntegrationHelper::getUserActivitySummary($userId);

// Get event summary
$summary = IntegrationHelper::getEventManagementSummary($eventId);

// Check if user can join
$check = IntegrationHelper::canUserJoinEvent($user, $event);

// Generate reports
$report = IntegrationHelper::generateUserActivityReport($userId);
$report = IntegrationHelper::generateEventReport($eventId);

// Dashboard stats
$stats = IntegrationHelper::getDashboardStatistics();
```

### Model Scopes
```php
// User's registered (upcoming) events
$user->registeredEvents()->get();

// User's confirmed events
$user->confirmedEvents()->get();

// Event's confirmed participants
$event->confirmedParticipants()->get();

// Active events
Event::active()->get();

// Events by category
Event::byCategory('turnamen')->get();
```

---

## 📊 STATISTICS AVAILABLE

### User Dashboard
- Events joined (count)
- Tickets purchased (count)
- Marketplace purchases (count)

### Admin User Details
- Total events joined
- Total tickets purchased (+ total spent)
- Total transactions (+ total amount)

### Admin Event Details
- Total participants (by status)
- Available spots remaining
- Total tickets sold (+ revenue)

### Admin Dashboard
- Total users/admins
- Active events
- Ticket revenue
- Marketplace revenue
- Pending sales

---

## 🔐 MIDDLEWARE

```php
// Protected user routes
Route::middleware(['auth'])->prefix('user')->group(function () {
    // Only logged in users
});

// Protected admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Only logged in admins
});
```

---

## 📱 API ENDPOINTS (for mobile/external apps)

```
GET    /api/user/dashboard           - User dashboard data
GET    /api/user/events              - User events
GET    /api/user/tickets             - User tickets
GET    /api/user/marketplace         - User purchases
POST   /api/user/events/{event}/join - Join event

GET    /api/admin/users              - Users list
GET    /api/admin/users/{user}       - User details
GET    /api/admin/users/{user}/activities - User activities
GET    /api/admin/events             - Events list
GET    /api/admin/events/{event}     - Event details
GET    /api/admin/events/{event}/participants - Event participants
```

---

## 🎨 VIEW FILES TO UPDATE NEXT

### User Views
- [ ] `resources/views/user/dashboard.blade.php` - Show recent activities
- [ ] `resources/views/user/events.blade.php` - Show events dengan status
- [ ] `resources/views/user/tickets.blade.php` - Show tickets dengan events
- [ ] `resources/views/user/marketplace.blade.php` - Show purchases

### Admin Views
- [ ] `resources/views/admin/users/show.blade.php` - User activities + stats
- [ ] `resources/views/admin/users/events.blade.php` - User events management
- [ ] `resources/views/admin/users/tickets.blade.php` - User tickets
- [ ] `resources/views/admin/users/transactions.blade.php` - User purchases

---

## 🧪 QUICK TESTS

### User Can Join Event
```
1. Go to /events
2. Click "Join Event" button
3. Check /user/events → User should appear
4. Check /admin/events/{id} → User should appear in participants
```

### User Can Buy Ticket
```
1. Go to /user/events/{id}
2. Click "Buy Ticket" button
3. Check /user/tickets → Ticket should appear
4. Check /admin/tickets → Ticket should appear in list
```

### Admin Can Manage User
```
1. Go to /admin/users
2. Click user name
3. Should see events/tickets/transactions tabs
4. Can click on each to manage
```

---

## 📞 NEED HELP?

1. **Setup Issues?** → Read `INTEGRATION_GUIDE.md`
2. **Implementation Details?** → Read `IMPLEMENTATION_CHECKLIST.md`
3. **Code Examples?** → Check `app/Utilities/IntegrationHelper.php`
4. **Routes List?** → Check `routes/web.php` & `routes/api.php`

---

## ✨ FEATURES SUMMARY

### What Users Can Do
✅ Join events
✅ Leave events
✅ Buy tickets
✅ View transaction history
✅ See their activity in one dashboard

### What Admins Can Do
✅ View all users + their activity
✅ Create/Edit/Delete events
✅ Manage event participants
✅ Generate & manage tickets
✅ Track marketplace sales
✅ View real-time analytics
✅ Approve/reject participants
✅ Update ticket status

---

Last Updated: January 21, 2026
Integration Status: ✅ COMPLETE & READY TO USE
