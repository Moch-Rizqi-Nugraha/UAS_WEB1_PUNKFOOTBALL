# Working Example Implementation

This file shows complete working examples of the enhancement patterns.

---

## Example 1: Complete UserController with Enhancements

File: `app/Http/Controllers/Admin/UserController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin');
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $users = User::paginate(15);

            return request()->expectsJson()
                ? $this->successResponse($users, 'Users retrieved successfully')
                : view('admin.users.index', compact('users'));

        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to fetch users')
                : back()->with('error', 'Failed to fetch users');
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            return view('admin.users.create');

        } catch (\Exception $e) {
            Log::error('Error loading user create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load form');
        }
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            Log::info("Admin " . Auth::id() . " created user: {$user->id} ({$user->email})");

            return request()->expectsJson()
                ? $this->createdResponse($user, 'User created successfully')
                : redirect()->route('admin.users.show', $user)->with('success', 'User created successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('Model not found while creating user: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->notFoundResponse('Resource not found')
                : back()->with('error', 'Resource not found');

        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to create user')
                : back()->with('error', 'Failed to create user');
        }
    }

    /**
     * Display a specific user
     */
    public function show(User $user)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $userEvents = $user->registeredEvents()->paginate(10);
            $userTickets = $user->tickets()->paginate(10);
            $userTransactions = $user->transactions()->paginate(10);

            return request()->expectsJson()
                ? $this->successResponse([
                    'user' => $user,
                    'events' => $userEvents,
                    'tickets' => $userTickets,
                    'transactions' => $userTransactions,
                ])
                : view('admin.users.show', compact('user', 'userEvents', 'userTickets', 'userTransactions'));

        } catch (ModelNotFoundException $e) {
            Log::error('User not found: ' . $user->id);
            
            return request()->expectsJson()
                ? $this->notFoundResponse('User not found')
                : back()->with('error', 'User not found');

        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to fetch user')
                : back()->with('error', 'Failed to fetch user');
        }
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            return view('admin.users.edit', compact('user'));

        } catch (\Exception $e) {
            Log::error('Error loading user edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load form');
        }
    }

    /**
     * Update a user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $validated = $request->validated();

            // Hash password if it's being updated
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $oldData = $user->toArray();
            $user->update($validated);

            Log::info("Admin " . Auth::id() . " updated user {$user->id}: " . json_encode([
                'old' => $oldData,
                'new' => $user->toArray(),
            ]));

            return request()->expectsJson()
                ? $this->successResponse($user, 'User updated successfully')
                : redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('User not found during update: ' . $user->id);
            
            return request()->expectsJson()
                ? $this->notFoundResponse('User not found')
                : back()->with('error', 'User not found');

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to update user')
                : back()->with('error', 'Failed to update user');
        }
    }

    /**
     * Delete a user (soft delete)
     */
    public function destroy(User $user)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            if ($user->id === Auth::id()) {
                return request()->expectsJson()
                    ? $this->errorResponse('Cannot delete your own account', 400)
                    : back()->with('error', 'Cannot delete your own account');
            }

            $user->delete(); // Soft delete

            Log::warning("Admin " . Auth::id() . " deleted user: {$user->id} ({$user->email})");

            return request()->expectsJson()
                ? $this->successResponse(null, 'User deleted successfully')
                : redirect()->route('admin.users.index')->with('success', 'User deleted successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('User not found during deletion: ' . $user->id);
            
            return request()->expectsJson()
                ? $this->notFoundResponse('User not found')
                : back()->with('error', 'User not found');

        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to delete user')
                : back()->with('error', 'Failed to delete user');
        }
    }

    /**
     * Restore a soft-deleted user
     */
    public function restore(User $user)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $user->restore();

            Log::info("Admin " . Auth::id() . " restored user: {$user->id} ({$user->email})");

            return request()->expectsJson()
                ? $this->successResponse($user, 'User restored successfully')
                : redirect()->route('admin.users.show', $user)->with('success', 'User restored successfully');

        } catch (\Exception $e) {
            Log::error('Error restoring user: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to restore user')
                : back()->with('error', 'Failed to restore user');
        }
    }
}
```

---

## Example 2: Complete EventController with Enhancements

File: `app/Http/Controllers/Admin/EventController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Notifications\EventParticipantApproved;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin');
    }

    public function index()
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $events = Event::with('category', 'participants')
                ->withCount('participants')
                ->paginate(15);

            return request()->expectsJson()
                ? $this->successResponse($events, 'Events retrieved')
                : view('admin.events.index', compact('events'));

        } catch (\Exception $e) {
            Log::error('Error fetching events: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to fetch events')
                : back()->with('error', 'Failed to fetch events');
        }
    }

    public function store(StoreEventRequest $request)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $validated = $request->validated();
            $event = Event::create($validated);

            Log::info("Admin " . Auth::id() . " created event: {$event->id} ({$event->name})");

            return request()->expectsJson()
                ? $this->createdResponse($event, 'Event created successfully')
                : redirect()->route('admin.events.show', $event)->with('success', 'Event created');

        } catch (\Exception $e) {
            Log::error('Error creating event: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to create event')
                : back()->with('error', 'Failed to create event');
        }
    }

    public function show(Event $event)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $participants = $event->participants()->with('user')->paginate(20);
            $pendingApprovals = $event->participants()
                ->where('status', 'pending')
                ->with('user')
                ->get();

            return request()->expectsJson()
                ? $this->successResponse([
                    'event' => $event,
                    'participants' => $participants,
                    'pending_count' => count($pendingApprovals),
                ])
                : view('admin.events.show', compact('event', 'participants', 'pendingApprovals'));

        } catch (ModelNotFoundException $e) {
            Log::error('Event not found: ' . $event->id);
            
            return request()->expectsJson()
                ? $this->notFoundResponse('Event not found')
                : back()->with('error', 'Event not found');

        } catch (\Exception $e) {
            Log::error('Error fetching event: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to fetch event')
                : back()->with('error', 'Failed to fetch event');
        }
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $validated = $request->validated();
            $oldData = $event->toArray();
            $event->update($validated);

            Log::info("Admin " . Auth::id() . " updated event {$event->id}");

            return request()->expectsJson()
                ? $this->successResponse($event, 'Event updated successfully')
                : redirect()->route('admin.events.show', $event)->with('success', 'Event updated');

        } catch (\Exception $e) {
            Log::error('Error updating event: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to update event')
                : back()->with('error', 'Failed to update event');
        }
    }

    public function approveParticipant($eventId, $participantId)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $event = Event::findOrFail($eventId);
            $participant = EventParticipant::findOrFail($participantId);

            if ($participant->event_id !== $event->id) {
                return request()->expectsJson()
                    ? $this->errorResponse('Participant does not belong to this event', 400)
                    : back()->with('error', 'Invalid participant');
            }

            $participant->update(['status' => 'approved']);

            // Send notification
            $participant->user->notify(new EventParticipantApproved($event, $participant->user));

            Log::info("Admin " . Auth::id() . " approved participant {$participantId} for event {$eventId}");

            return request()->expectsJson()
                ? $this->successResponse($participant, 'Participant approved')
                : back()->with('success', 'Participant approved');

        } catch (ModelNotFoundException $e) {
            Log::error('Model not found during approval: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->notFoundResponse('Resource not found')
                : back()->with('error', 'Resource not found');

        } catch (\Exception $e) {
            Log::error('Error approving participant: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to approve participant')
                : back()->with('error', 'Failed to approve participant');
        }
    }

    public function rejectParticipant($eventId, $participantId)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $participant = EventParticipant::findOrFail($participantId);
            $participant->update(['status' => 'rejected']);

            Log::warning("Admin " . Auth::id() . " rejected participant {$participantId} for event {$eventId}");

            return request()->expectsJson()
                ? $this->successResponse($participant, 'Participant rejected')
                : back()->with('success', 'Participant rejected');

        } catch (\Exception $e) {
            Log::error('Error rejecting participant: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to reject participant')
                : back()->with('error', 'Failed to reject participant');
        }
    }

    public function destroy(Event $event)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $event->delete(); // Soft delete

            Log::warning("Admin " . Auth::id() . " deleted event: {$event->id} ({$event->name})");

            return request()->expectsJson()
                ? $this->successResponse(null, 'Event deleted')
                : redirect()->route('admin.events.index')->with('success', 'Event deleted');

        } catch (\Exception $e) {
            Log::error('Error deleting event: ' . $e->getMessage());
            
            return request()->expectsJson()
                ? $this->serverErrorResponse('Failed to delete event')
                : back()->with('error', 'Failed to delete event');
        }
    }
}
```

---

## Example 3: API Usage Examples

### Testing with cURL

#### Create User (POST)
```bash
curl -X POST http://localhost:8000/api/admin/users \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "securepassword123",
    "password_confirmation": "securepassword123",
    "role": "user"
  }'
```

#### Success Response (201 Created)
```json
{
    "success": true,
    "message": "User created successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "user",
        "created_at": "2024-12-01T10:30:00Z"
    }
}
```

#### Validation Error Response (422)
```bash
curl -X POST http://localhost:8000/api/admin/users \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "invalid-email"
  }'
```

Response (422):
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email must be a valid email address"],
        "password": ["The password field is required"],
        "role": ["The role field is required"]
    }
}
```

#### Authorization Error (403)
```bash
curl -X POST http://localhost:8000/api/admin/users \
  -H "Authorization: Bearer USER_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name": "John", "email": "john@example.com"}'
```

Response (403):
```json
{
    "success": false,
    "message": "You do not have permission to perform this action"
}
```

#### Update Event (PUT)
```bash
curl -X PUT http://localhost:8000/api/admin/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Event Name",
    "description": "Updated description",
    "status": "active"
  }'
```

#### Delete User (DELETE)
```bash
curl -X DELETE http://localhost:8000/api/admin/users/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

Response (200 OK):
```json
{
    "success": true,
    "message": "User deleted successfully"
}
```

---

## Example 4: Testing in Postman

### Create Postman Collection

1. **New Request: Create User**
   - Method: POST
   - URL: `{{base_url}}/api/admin/users`
   - Headers:
     - Authorization: Bearer {{token}}
     - Content-Type: application/json
   - Body (JSON):
     ```json
     {
       "name": "Test User",
       "email": "test@example.com",
       "password": "password123",
       "password_confirmation": "password123",
       "role": "user"
     }
     ```

2. **New Request: Get User**
   - Method: GET
   - URL: `{{base_url}}/api/admin/users/1`
   - Headers:
     - Authorization: Bearer {{token}}

3. **New Request: Update User**
   - Method: PUT
   - URL: `{{base_url}}/api/admin/users/1`
   - Headers:
     - Authorization: Bearer {{token}}
     - Content-Type: application/json
   - Body:
     ```json
     {
       "name": "Updated Name",
       "email": "updated@example.com",
       "role": "admin"
     }
     ```

4. **New Request: Delete User**
   - Method: DELETE
   - URL: `{{base_url}}/api/admin/users/1`
   - Headers:
     - Authorization: Bearer {{token}}

---

## Example 5: Model Usage in Code

### Using Model Scopes
```php
// Get available tickets
$availableTickets = Ticket::available()->get();

// Get upcoming events
$upcomingEvents = Event::upcoming()->get();

// Get used tickets for specific event
$usedTickets = Ticket::where('event_id', $eventId)->used()->get();

// Get tickets ordered by creation date
$recentTickets = Ticket::latest('created_at')->available()->get();
```

### Using Model Helpers
```php
// Check ticket status
if ($ticket->isAvailable()) {
    // Can be purchased
}

if ($ticket->isUsed()) {
    // Already used
}

// Mark ticket as used
$ticket->markAsUsed();

// Cancel ticket
$ticket->cancel();

// Get status badge
echo $ticket->statusBadge; // Output: <span class="badge badge-success">Available</span>

// Event helpers
if ($event->isUpcoming()) {
    // Event is in the future
}

$participantCount = $event->getParticipantCount();
```

### Sending Notifications
```php
use App\Notifications\EventParticipantApproved;
use App\Notifications\TicketPurchaseConfirmation;

// Notify when participation approved
$user->notify(new EventParticipantApproved($event, $user));

// Notify when ticket purchased
$user->notify(new TicketPurchaseConfirmation($ticket));
```

### Logging Examples
```php
use Illuminate\Support\Facades\Log;

// Info level - track successful operations
Log::info("Admin {$adminId} created event {$eventId}");
Log::info("User {$userId} purchased ticket {$ticketId}");

// Error level - track failures
Log::error("Failed to create event: " . $e->getMessage());
Log::error("Database error: " . $e->getCode());

// Warning level - track suspicious activities
Log::warning("Admin {$adminId} deleted user {$userId}");
Log::warning("Multiple failed login attempts from {$ip}");
```

---

## Testing Checklist

For each controller method, test:

- [ ] **Success Case**: Valid request returns proper response with 2xx status
- [ ] **Validation Error**: Invalid data returns 422 with error messages
- [ ] **Authorization**: Non-admin user gets 403 Forbidden
- [ ] **Not Found**: Invalid ID returns 404 Not Found
- [ ] **Server Error**: Unexpected error returns 500 with message
- [ ] **Logging**: Check that logs contain appropriate entries
- [ ] **Database**: Verify data is saved correctly
- [ ] **JSON Response**: API returns proper JSON format
- [ ] **HTML Response**: Web requests return proper HTML

---

## Conclusion

These examples show how to:
1. Implement controllers with full error handling
2. Use ApiResponse trait for consistent responses
3. Apply FormRequest validation
4. Add proper authorization checks
5. Log all admin actions
6. Use model scopes and helpers
7. Send notifications
8. Test API endpoints

Reference these examples when enhancing remaining controllers.
