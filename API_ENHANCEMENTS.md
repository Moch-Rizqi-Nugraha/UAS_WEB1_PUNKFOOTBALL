# API Response Standards & Enhancement Documentation

## 1. Response Format

All API responses follow a standardized JSON format:

### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        "id": 1,
        "name": "Event Name"
    }
}
```

### Created Response (201 Created)
```json
{
    "success": true,
    "message": "Resource created successfully",
    "data": {
        "id": 1,
        "name": "New Resource"
    }
}
```

### Validation Error Response (422 Unprocessable Entity)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required"],
        "price": ["The price must be a valid number"]
    }
}
```

### Not Found Response (404 Not Found)
```json
{
    "success": false,
    "message": "Resource not found"
}
```

### Unauthorized Response (401 Unauthorized)
```json
{
    "success": false,
    "message": "Unauthenticated access"
}
```

### Forbidden Response (403 Forbidden)
```json
{
    "success": false,
    "message": "You do not have permission to perform this action"
}
```

### Server Error Response (500 Internal Server Error)
```json
{
    "success": false,
    "message": "An unexpected error occurred"
}
```

## 2. HTTP Status Codes Used

| Code | Meaning | Usage |
|------|---------|-------|
| 200 | OK | Successful GET, PATCH, PUT requests |
| 201 | Created | Successful POST requests |
| 204 | No Content | Successful DELETE requests (no data) |
| 400 | Bad Request | Malformed request syntax |
| 401 | Unauthorized | Authentication required or failed |
| 403 | Forbidden | Authenticated but no permission |
| 404 | Not Found | Resource doesn't exist |
| 422 | Unprocessable Entity | Validation failed |
| 429 | Too Many Requests | Rate limit exceeded |
| 500 | Server Error | Unexpected server error |

## 3. Trait Usage: ApiResponse

The `ApiResponse` trait provides standardized response methods:

```php
use App\Traits\ApiResponse;

class YourController extends Controller
{
    use ApiResponse;

    // Success response (200)
    return $this->successResponse($data, 'Success message');

    // Created response (201)
    return $this->createdResponse($data, 'Created successfully');

    // Validation error (422)
    return $this->validationErrorResponse($errors);

    // Not found (404)
    return $this->notFoundResponse('Resource not found');

    // Unauthorized (401)
    return $this->unauthorizedResponse('Please login');

    // Forbidden (403)
    return $this->forbiddenResponse('No permission');

    // Server error (500)
    return $this->serverErrorResponse('Server error');
}
```

## 4. Request Validation Classes

All endpoints use FormRequest classes for validation:

### Location
`app/Http/Requests/` directory

### Examples
- `StoreTicketRequest` - Create ticket validation
- `UpdateTicketRequest` - Update ticket validation
- `StoreEventRequest` - Create event validation
- `UpdateEventRequest` - Update event validation
- `StoreTransactionRequest` - Create transaction validation
- `UpdateTransactionRequest` - Update transaction validation

### Benefits
✓ Centralized validation rules
✓ Consistent error messages
✓ Authorization checks in FormRequest
✓ Type hinting in controller methods
✓ Cleaner controller code

## 5. Authorization Patterns

### At Route Level
```php
Route::middleware('auth:sanctum', 'admin')->group(function () {
    // Routes here require admin role
});
```

### At Controller/Method Level
```php
public function destroy($id)
{
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized');
    }
    // ... logic
}
```

### Using authorize() Method
```php
public function authorize()
{
    return auth()->user()?->isAdmin() ?? false;
}
```

## 6. Error Handling Pattern

All controller methods follow this pattern:

```php
public function store(StoreTicketRequest $request)
{
    try {
        // Authorization check (via middleware or FormRequest)
        $this->authorize();

        // Validation (via FormRequest)
        $validated = $request->validated();

        // Business logic
        $ticket = Ticket::create($validated);

        // Logging
        Log::info("Ticket created by admin: " . auth()->id());

        // Response
        return request()->expectsJson()
            ? $this->createdResponse($ticket, 'Ticket created')
            : redirect()->route('admin.tickets.show', $ticket)->with('success', 'Ticket created');

    } catch (ModelNotFoundException $e) {
        Log::error('Model not found: ' . $e->getMessage());
        return request()->expectsJson()
            ? $this->notFoundResponse('Resource not found')
            : back()->with('error', 'Resource not found');

    } catch (\Exception $e) {
        Log::error('Error creating ticket: ' . $e->getMessage());
        return request()->expectsJson()
            ? $this->serverErrorResponse('Failed to create ticket')
            : back()->with('error', 'Failed to create ticket');
    }
}
```

## 7. Logging Standards

### Info Level - Track important business events
```php
Log::info("Admin {$adminId} created ticket #{$ticketId}");
Log::info("User {$userId} purchased event participation");
Log::info("Transaction {$transactionId} status changed to completed");
```

### Error Level - Track failures and issues
```php
Log::error("Failed to create ticket: " . $e->getMessage());
Log::error("Validation failed for event: " . json_encode($errors));
Log::error("Database error in EventController@store");
```

### Location
`storage/logs/laravel.log`

## 8. Soft Delete Implementation

Models now use SoftDeletes trait:

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
```

### Database Query Impact
- `Ticket::all()` - Excludes soft-deleted records
- `Ticket::withTrashed()->get()` - Includes soft-deleted
- `Ticket::onlyTrashed()->get()` - Only soft-deleted
- `$ticket->restore()` - Restore soft-deleted
- `$ticket->forceDelete()` - Permanently delete

## 9. Model Helper Methods

Models now include helper methods to reduce controller logic:

### Ticket Model
```php
$ticket->isAvailable() // Check if available
$ticket->isUsed() // Check if used
$ticket->isExpired() // Check if expired
$ticket->markAsUsed() // Mark as used
$ticket->cancel() // Cancel ticket
$ticket->statusBadge // Get HTML badge
```

### Event Model
```php
$event->isUpcoming() // Check if upcoming
$event->isPast() // Check if past
$event->isInactive() // Check if inactive
$event->getParticipantCount() // Get participant count
$event->statusBadge // Get HTML badge
```

## 10. Rate Limiting

### Using Middleware
```php
Route::middleware('rate.limit:60,1')->group(function () {
    // 60 requests per minute per user/IP
});
```

### Response Headers
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1234567890
```

## 11. Notification System

### Email Notifications
- `EventParticipantApproved` - Sent when participation is approved
- `TicketPurchaseConfirmation` - Sent when ticket is purchased
- `TransactionStatusUpdate` - Sent when transaction status changes

### Database Notifications
All notifications are also logged in database for in-app notifications.

### Usage
```php
$user->notify(new EventParticipantApproved($event, $user));
$user->notify(new TicketPurchaseConfirmation($ticket));
```

## 12. Validation Request Classes

All validation rules are centralized in FormRequest classes:

### StoreTicketRequest
- ticket_number: required, unique, string, max:50
- event_id: required, exists in events table
- price: required, numeric, min:0
- quantity: required, integer, 1-1000
- status: required, in [available, used, cancelled, expired]

### StoreEventRequest
- name: required, string, max:100
- description: required, string, max:1000
- event_date: required, date, after today
- location: required, string, max:100
- category_id: required, exists
- status: required, in [active, cancelled, completed]
- max_participants: required, integer, 1-10000

### StoreTransactionRequest
- user_id: required, exists
- ticket_id: required, exists
- amount: required, numeric, min:0
- transaction_date: required, date
- status: required, in [pending, completed, failed, refunded]
- payment_method: required, in [bank_transfer, credit_card, e_wallet, cash]

## 13. Best Practices

✓ **Always use FormRequest classes** - Don't validate in controllers
✓ **Check authorization early** - Before any business logic
✓ **Log important events** - Info level for success, Error for failures
✓ **Use try-catch blocks** - Catch exceptions and return proper errors
✓ **Return proper status codes** - 201 for create, 204 for delete, 404 for not found
✓ **Consistent response format** - Use ApiResponse trait
✓ **Add rate limiting** - Protect endpoints from abuse
✓ **Use soft deletes** - Never permanently delete records
✓ **Send notifications** - Keep users informed of actions
✓ **Use model helpers** - Reduce code duplication

## 14. Future Enhancements

- [ ] Add database indexes for performance
- [ ] Implement caching layer for frequently accessed data
- [ ] Add webhook support for external integrations
- [ ] Implement event broadcasting for real-time updates
- [ ] Add CSV export functionality for reports
- [ ] Implement advanced search with filters
- [ ] Add pagination to all list endpoints
- [ ] Implement API versioning
- [ ] Add request/response logging middleware
- [ ] Implement API documentation with Swagger/OpenAPI
