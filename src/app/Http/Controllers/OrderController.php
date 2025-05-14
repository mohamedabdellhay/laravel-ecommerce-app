<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::with(['user', 'items']);

        // Apply status filter
        if (request()->has('status') && request('status') !== '') {
            $query->where('status', request('status'));
        }

        // Apply user filter
        if (request()->has('user_id') && request('user_id') !== '') {
            $query->where('user_id', request('user_id'));
        }

        // Apply sorting
        if (request()->has('sort')) {
            if (request('sort') === 'oldest') {
                $query->oldest();
            } else {
                $query->latest();
            }
        } else {
            // Default sort by newest
            $query->latest();
        }

        $orders = $query->paginate(10)->withQueryString();
        $users = User::all();

        if (request()->ajax()) {
            return response()->json([
                'orders' => view('admin.orders.partials.order_rows', compact('orders'))->render(),
                'pagination' => $orders->links()->toHtml(),
            ]);
        }
        return view('admin.orders.index', compact('orders', 'users'));
    }



    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        // Example request data:
        // {
        //   "_token": "WikokhBNuXymAOfajsOgqG8CHNxOXrnLvY5UCXPr",
        //   "user_id": "1",
        //   "status": "pending",
        //   "items": [
        //     {
        //       "product_id": "1",
        //       "quantity": "1",
        //       "price": "500"
        //     },
        //     {
        //       "product_id": "2",
        //       "quantity": "1",
        //       "price": "600"
        //     }
        //   ]
        // }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
        // return $validator->errors();
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $total_amount = collect($request->items)->sum(function ($item): int {
            return $item['quantity'] * $item['price'];
        });
        // return $total_amount;
        $order = Order::create([
            'user_id' => $request->user_id,
            'status' => $request->status,
            'total' => $total_amount,
        ]);
        // return $order;
        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'variant_id' => $item['variant_id'] ?? 1, // Adding variant_id to fix NOT NULL constraint
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', __('Order created successfully'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.orders.edit', compact('order', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|in:pending,processing,shipped,delivered,cancelled',
            'items' => 'sometimes|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $order->update($request->only(['user_id', 'status']));

        if ($request->has('items')) {
            $order->items()->delete();
            $total_amount = collect($request->items)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });
            $order->update(['total_amount' => $total_amount]);

            foreach ($request->items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        return redirect()->route('admin.orders.index')->with('success', __('Order updated successfully'));
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // First delete all related items to avoid foreign key constraints
            $order->items()->delete();

            // Then delete the order
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => __('Order deleted successfully')
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('Failed to delete order: ') . $e->getMessage()
            ], 500);
        }
    }
}
