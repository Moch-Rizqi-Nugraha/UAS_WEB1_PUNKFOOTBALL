<?php
namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MarketplaceController extends Controller
{
    /**
     * Display a listing of marketplace transactions and products.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all'); // all, pending, completed, cancelled
        
        $transactions = Transaction::query()
            ->when($search, fn($q) => $q->where('item_name', 'like', "%$search%")
                                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%")))
            ->when($filter !== 'all', fn($q) => $q->where('status', $filter))
            ->with(['user', 'product'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);

        // Get product stats
        $stats = [
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'completed_sales' => Transaction::where('status', 'completed')->sum('amount'),
            'pending_sales' => Transaction::where('status', 'pending')->sum('amount'),
        ];

        return view('admin.marketplace.index', compact('transactions', 'stats', 'search', 'filter'));
    }

    /**
     * Show form to create a new marketplace product/transaction.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.marketplace.create', compact('users'));
    }

    /**
     * Store a new marketplace product and transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create product
        $product = new Product();
        $product->name = $request->product_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;
        
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }
        $product->save();

        // Create transaction if user is assigned
        if ($request->user_id) {
            Transaction::create([
                'user_id' => $request->user_id,
                'product_id' => $product->id,
                'transaction_type' => 'purchase',
                'item_name' => $product->name,
                'amount' => $product->price,
                'status' => 'completed',
                'transaction_date' => now(),
            ]);
        }

        return redirect()->route('admin.marketplace.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show details of a transaction.
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'product'])->findOrFail($id);
        return view('admin.marketplace.show', compact('transaction'));
    }

    /**
     * Edit product
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.marketplace.edit', compact('product'));
    }

    /**
     * Update product or transaction
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('admin.marketplace.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Update transaction status
     */
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $transaction->status = $request->status;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaction status updated.'
        ]);
    }

    /**
     * Get user transaction history
     */
    public function userTransactions(User $user)
    {
        $transactions = $user->transactions()
                            ->with('product')
                            ->orderBy('transaction_date', 'desc')
                            ->paginate(15);

        $stats = [
            'total_purchases' => $user->transactions()->count(),
            'total_spent' => $user->transactions()->where('status', 'completed')->sum('amount'),
            'pending' => $user->transactions()->where('status', 'pending')->count(),
        ];

        return view('admin.marketplace.user-transactions', compact('user', 'transactions', 'stats'));
    }

    /**
     * Get product sales history
     */
    public function productSales(Product $product)
    {
        $transactions = Transaction::where('product_id', $product->id)
                                   ->with('user')
                                   ->orderBy('transaction_date', 'desc')
                                   ->paginate(15);

        $stats = [
            'total_sales' => $transactions->count(),
            'total_revenue' => Transaction::where('product_id', $product->id)
                                         ->where('status', 'completed')
                                         ->sum('amount'),
        ];

        return view('admin.marketplace.product-sales', compact('product', 'transactions', 'stats'));
    }
}
