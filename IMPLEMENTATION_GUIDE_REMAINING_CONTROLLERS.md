# Quick Implementation Guide - Remaining Controllers

This guide shows how to apply the TicketController pattern to remaining controllers.

---

## Template Pattern Used in TicketController

```php
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class ControllerTemplate extends Controller
{
    use ApiResponse;

    // Authorization check
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin');
    }

    // Store method example
    public function store(StoreTicketRequest $request)
    {
        try {
            // Validation already done by FormRequest
            $validated = $request->validated();

            // Check authorization
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            // Business logic
            $resource = Model::create($validated);

            // Log success
            Log::info("Admin {$adminId} created resource: {$resource->id}");

            // Return response
            return request()->expectsJson()
                ? $this->createdResponse($resource, 'Resource created')
                : redirect()->route('admin.resource.show', $resource)->with('success', 'Created');

        } catch (ModelNotFoundException $e) {
            Log::error('Model not found: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->notFoundResponse()
                : back()->with('error', 'Resource not found');

        } catch (\Exception $e) {
            Log::error('Error creating resource: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->serverErrorResponse()
                : back()->with('error', 'Failed to create resource');
        }
    }
}
```

---

## UserController Enhancement Plan

### Current Status
- Exists at `app/Http/Controllers/Admin/UserController.php`
- Manages admin user activity view
- Needs: Error handling, logging, authorization

### Implementation Steps

#### Step 1: Add Trait and Use Statements
```php
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    use ApiResponse;
```

#### Step 2: Add Constructor
```php
public function __construct()
{
    $this->middleware('auth:sanctum');
    $this->middleware('admin');
}
```

#### Step 3: Enhance Each Method (index, show, create, store, edit, update, destroy)
```php
public function store(StoreUserRequest $request)
{
    try {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validated();
        $user = User::create($validated);

        Log::info("Admin " . auth()->id() . " created user: {$user->id}");

        return request()->expectsJson()
            ? $this->createdResponse($user)
            : redirect()->route('admin.users.show', $user)->with('success', 'User created');

    } catch (\Exception $e) {
        Log::error('Error creating user: ' . $e->getMessage());
        return request()->expectsJson()
            ? $this->serverErrorResponse()
            : back()->with('error', 'Failed to create user');
    }
}
```

### Files Needed
- Create: `app/Http/Requests/StoreUserRequest.php`
- Create: `app/Http/Requests/UpdateUserRequest.php`
- Update: `app/Http/Controllers/Admin/UserController.php`

### Validation Fields
```php
// StoreUserRequest
'name' => ['required', 'string', 'max:100'],
'email' => ['required', 'email', 'unique:users'],
'password' => ['required', 'string', 'min:8', 'confirmed'],
'role' => ['required', 'in:admin,user'],
```

---

## EventController Enhancement Plan

### Current Status
- Exists at `app/Http/Controllers/Admin/EventController.php`
- Manages event creation and participant tracking
- Needs: Better error handling, form request validation, logging

### Implementation Steps

#### Step 1: Create Validation Requests
```php
// app/Http/Requests/StoreEventRequest.php
'name' => ['required', 'string', 'max:100'],
'description' => ['required', 'string', 'max:1000'],
'event_date' => ['required', 'date', 'after:today'],
'location' => ['required', 'string', 'max:100'],
'category_id' => ['required', 'integer', 'exists:categories,id'],
'max_participants' => ['required', 'integer', 'min:1', 'max:10000'],
```

#### Step 2: Update Controller Methods
```php
public function store(StoreEventRequest $request)
{
    try {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validated();
        $event = Event::create($validated);

        Log::info("Admin " . auth()->id() . " created event: {$event->id}");

        return request()->expectsJson()
            ? $this->createdResponse($event, 'Event created')
            : redirect()->route('admin.events.show', $event)->with('success', 'Event created');

    } catch (\Exception $e) {
        Log::error('Error creating event: ' . $e->getMessage());
        return request()->expectsJson()
            ? $this->serverErrorResponse()
            : back()->with('error', 'Failed to create event');
    }
}
```

### Key Methods to Enhance
1. `index()` - Add error handling, logging
2. `show()` - Add authorization, proper error responses
3. `create()` - Keep as view response
4. `store()` - Add FormRequest, error handling, logging
5. `edit()` - Keep as view response
6. `update()` - Add FormRequest, error handling, logging
7. `destroy()` - Add soft delete with logging
8. `approveParticipant()` - Add authorization, logging, notification
9. `rejectParticipant()` - Add authorization, logging

---

## MarketplaceController Enhancement Plan

### Current Status
- Manages products and transactions
- Needs: Form request validation, error handling, transaction logging

### Implementation Steps

#### Step 1: Create Validation Requests
```php
// app/Http/Requests/StoreProductRequest.php
'name' => ['required', 'string', 'max:100'],
'description' => ['required', 'string', 'max:1000'],
'price' => ['required', 'numeric', 'min:0'],
'stock' => ['required', 'integer', 'min:0'],
'category_id' => ['nullable', 'integer', 'exists:categories,id'],

// app/Http/Requests/StoreTransactionRequest.php
'user_id' => ['required', 'integer', 'exists:users,id'],
'product_id' => ['required', 'integer', 'exists:products,id'],
'quantity' => ['required', 'integer', 'min:1'],
'amount' => ['required', 'numeric', 'min:0'],
'status' => ['required', 'in:pending,completed,failed,refunded'],
'payment_method' => ['required', 'in:bank_transfer,credit_card,e_wallet,cash'],
```

#### Step 2: Update Methods
```php
public function storeProduct(StoreProductRequest $request)
{
    try {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validated();
        $product = Product::create($validated);

        Log::info("Admin " . auth()->id() . " created product: {$product->id}");

        return request()->expectsJson()
            ? $this->createdResponse($product, 'Product created')
            : redirect()->route('admin.products.show', $product)->with('success', 'Product created');

    } catch (\Exception $e) {
        Log::error('Error creating product: ' . $e->getMessage());
        return request()->expectsJson()
            ? $this->serverErrorResponse()
            : back()->with('error', 'Failed to create product');
    }
}
```

### Transaction Logging
```php
// Log all transaction changes
Log::info("Admin " . auth()->id() . " updated transaction {$transaction->id}: {$oldStatus} -> {$newStatus}");

// Log failed transactions
Log::error("Transaction {$transaction->id} failed: {$error}");

// Log refunds
Log::warning("Admin " . auth()->id() . " refunded transaction {$transaction->id}: Rp " . number_format($transaction->amount, 0));
```

---

## Validation Request Template

Create all validation request classes at: `app/Http/Requests/`

### Basic Template
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResourceRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules()
    {
        return [
            'field1' => ['required', 'string', 'max:100'],
            'field2' => ['required', 'integer', 'exists:table,id'],
            'field3' => ['required', Rule::in(['option1', 'option2'])],
        ];
    }

    public function messages()
    {
        return [
            'field1.required' => 'Field 1 is required',
            'field2.exists' => 'Selected option does not exist',
            'field3.in' => 'Please select a valid option',
        ];
    }
}
```

---

## Checklist for Each Controller

Use this checklist when enhancing each controller:

- [ ] Add `use App\Traits\ApiResponse;` at top
- [ ] Add `use Illuminate\Support\Facades\Log;` at top
- [ ] Add `use App\Http\Requests\StoreXRequest;` and `UpdateXRequest;`
- [ ] Add trait: `use ApiResponse;` in class
- [ ] Add constructor with middleware
- [ ] Wrap all methods in try-catch blocks
- [ ] Add authorization check: `if (!auth()->user()->isAdmin()) abort(403);`
- [ ] Log important events: `Log::info("Admin {$id} did something");`
- [ ] Use FormRequest validation: `$validated = $request->validated();`
- [ ] Return proper status codes (201 for create, 404 for not found, 500 for error)
- [ ] Use ApiResponse methods: `$this->successResponse()`, `$this->createdResponse()`, etc.
- [ ] Handle dual responses: `request()->expectsJson() ? ... : ...`
- [ ] Test with both JSON and HTML requests
- [ ] Verify error messages are user-friendly
- [ ] Check logs for proper formatting

---

## Testing Each Method

After implementation, test each method:

### Store Method
```bash
# Valid request
curl -X POST http://localhost/api/admin/resource \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "field1": "value1",
    "field2": 1
  }'

# Invalid request (missing required field)
curl -X POST http://localhost/api/admin/resource \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"field1": "value1"}'

# Unauthorized (without token)
curl -X POST http://localhost/api/admin/resource \
  -H "Content-Type: application/json" \
  -d '{"field1": "value1", "field2": 1}'
```

### Update Method
```bash
curl -X PUT http://localhost/api/admin/resource/1 \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "field1": "updated_value"
  }'
```

### Delete Method
```bash
curl -X DELETE http://localhost/api/admin/resource/1 \
  -H "Authorization: Bearer TOKEN"
```

---

## Estimated Time to Complete

- **UserController**: 1-2 hours
  - 1 hour to enhance existing methods
  - 30 mins to create validation requests
  - 30 mins to test

- **EventController**: 1-2 hours
  - 1 hour to enhance methods
  - 30 mins to create validation requests
  - 30 mins to test participant approval flow

- **MarketplaceController**: 1-2 hours
  - 1 hour to enhance product management
  - 1 hour to enhance transaction management
  - 30 mins to test payment flow

**Total: 3-6 hours for all remaining controllers**

---

## Common Issues & Solutions

### Issue: "Call to undefined method ApiResponse"
**Solution**: Add `use App\Traits\ApiResponse;` and `use ApiResponse;` in class

### Issue: Validation errors not showing
**Solution**: Make sure FormRequest `authorize()` returns true, check `rules()` method

### Issue: Authorization not working
**Solution**: Verify middleware is registered in `app/Http/Kernel.php`

### Issue: Logs not appearing
**Solution**: Check `storage/logs/laravel.log`, ensure Log::info() is called

### Issue: Status codes not correct
**Solution**: Use trait methods: `createdResponse()` (201), `notFoundResponse()` (404), etc.

---

## Implementation Order

1. **Start with UserController** (simplest)
2. **Then EventController** (medium complexity, participant logic)
3. **Finally MarketplaceController** (most complex, payment logic)

This order allows you to refine the pattern as you go.

---

## Support Reference

See these files for complete details:
- `API_ENHANCEMENTS.md` - Response formats and patterns
- `ENHANCEMENT_CHECKLIST.md` - What's been done
- `app/Http/Controllers/Admin/TicketController.php` - Reference implementation
- `app/Traits/ApiResponse.php` - Available response methods
