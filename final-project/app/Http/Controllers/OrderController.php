<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $statusFilter = $request->input('status-filter');
        $duration = $request->input('duration');
        $now = now();
        if ($user->role === 'seller') {
            // Ambil input pencarian dan filter
            $search = $request->input('search');

            // Query dengan pencarian dan filter
            $orders = Order::with(['user', 'orderItems.product.store'])
                ->whereHas('orderItems.product.store', function ($query) use ($user) {
                    $query->where('seller_id', $user->id);
                })
                ->whereHas('user', function ($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    }
                })
                ->when($statusFilter, function ($query) use ($statusFilter) {
                    $query->where('status', $statusFilter);
                })
                ->paginate(10);

                return view('dashboard.seller.orders.index', compact('orders'));
        } elseif($user->role === 'buyer') {
            $orders = Order::where('user_id', $user->id)
            ->when($statusFilter, function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->when($duration, function ($query) use ($duration, $now) {
                switch ($duration) {
                    case 'this week':
                        $query->whereBetween('created_at', [(clone $now)->startOfWeek(), (clone $now)->endOfWeek()]);
                        break;
                    case 'this month':
                        $query->whereBetween('created_at', [(clone $now)->startOfMonth(), (clone $now)->endOfMonth()]);
                        break;
                    case 'last 3 months':
                        $query->whereBetween('created_at', [(clone $now)->subMonths(3)->startOfMonth(), (clone $now)->endOfMonth()]);
                        break;
                    case 'last 6 months':
                        $query->whereBetween('created_at', [(clone $now)->subMonths(6)->startOfMonth(), (clone $now)->endOfMonth()]);
                        break;
                    case 'this year':
                        $query->whereYear('created_at', $now->year);
                        break;
                }
            })            
            ->paginate(10);
            return view('dashboard.buyer.orders.index', compact('orders'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    
    //     // Validasi apakah user memiliki role buyer
    //     if ($user->role !== 'buyer') {
    //         return redirect()->back()->with('error', 'Only buyers can proceed with orders.');
    //     }
    
    //     // Ambil keranjang user
    //     $cart = $user->cart;
    
    //     // Validasi apakah keranjang tidak kosong
    //     if (!$cart || $cart->cartItems->isEmpty()) {
    //         return redirect()->back()->with('error', 'Your cart is empty.');
    //     }
    
    //     // Hitung total harga
    //     $originalPrice = $cart->cartItems->sum('price');
    //     $tax = $originalPrice * 0.10; // Pajak 10%
    //     $storePickup = 20; // Biaya pengambilan toko
    //     $totalPrice = $originalPrice + $tax + $storePickup;
    
    //     // Buat order baru langsung dengan model Order
    //     $order = Order::create([
    //         'user_id' => $user->id, // Set user_id secara manual
    //         'status' => 'on progress',
    //         'total_price' => $totalPrice, // Pastikan menggunakan nama atribut yang benar
    //         'order_date' => now(),
    //         'address' => $user->address, // Ambil dari user
    //     ]);
    
    //     // Tambahkan data ke tabel order_tracking
    //     $order->orderTracking()->create([
    //         'status' => 'on progress',
    //         'update_time' => now(),
    //     ]);
    
    //     // Pindahkan cart_items ke order_items
    //     foreach ($cart->cartItems as $cartItem) {
    //         $order->orderItems()->create([
    //             'product_id' => $cartItem->product_id,
    //             'quantity' => $cartItem->quantity,
    //             'price' => $cartItem->price,
    //         ]);
    //     }
    
    //     // Kosongkan keranjang
    //     $cart->cartItems()->delete();
    
    //     return redirect()->route('dashboard.buyer.orders.index')
    //         ->with('success', 'Order created successfully.');
    // }    

    public function store(Request $request)
{
    $user = Auth::user();

    // Validasi apakah user memiliki role buyer
    if ($user->role !== 'buyer') {
        return redirect()->back()->with('error', 'Only buyers can proceed with orders.');
    }

    // Ambil keranjang user
    $cart = $user->cart;

    // Validasi apakah keranjang tidak kosong
    if (!$cart || $cart->cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    // Hitung total harga
    $originalPrice = $cart->cartItems->sum('price');
    $tax = $originalPrice * 0.10; // Pajak 10%
    $storePickup = 20; // Biaya pengambilan toko
    $totalPrice = $originalPrice + $tax + $storePickup;

    // Buat order baru
    $order = Order::create([
        'user_id' => $user->id,
        'status' => 'on progress',
        'total_price' => $totalPrice,
        'order_date' => now(),
        'address' => $user->address,
    ]);

    // Tambahkan data ke tabel order_tracking
    $order->orderTracking()->create([
        'status' => 'on progress',
        'update_time' => now(),
    ]);

    // Validasi stok dan pindahkan cart_items ke order_items
    foreach ($cart->cartItems as $cartItem) {
        $product = Product::find($cartItem->product_id);

        if (!$product) {
            return redirect()->back()->with('error', "Product with ID {$cartItem->product_id} not found.");
        }

        if ($cartItem->quantity > $product->stock) {
            // Hapus order jika stok tidak mencukupi
            $order->delete();
            return redirect()->back()->with('error', "Insufficient stock for product: {$product->name}. Available stock: {$product->stock}.");
        }

        // Kurangi stok produk
        $product->stock -= $cartItem->quantity;
        $product->save();

        // Pindahkan item ke order_items
        $order->orderItems()->create([
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->price,
        ]);
    }

    // Kosongkan keranjang
    $cart->cartItems()->delete();

    return redirect()->route('dashboard.buyer.orders.index')
        ->with('success', 'Order created successfully.');
}

    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        if ($user->role === 'buyer') {
             // Buyer hanya bisa melihat order miliknya sendiri
        $order = Order::where('id', $id)
        ->where('user_id', $user->id) // Filter berdasarkan user_id
        ->with(['orderItems.product', 'orderTracking']) // Ambil relasi orderTracking
        ->firstOrFail();

        // Ambil setiap status dengan updated_at-nya
        $onProgressStatus = $order->orderTracking->firstWhere('status', 'On progress');
        $pendingStatus = $order->orderTracking->firstWhere('status', 'pending');
        $shippedStatus = $order->orderTracking->firstWhere('status', 'shipped');
        $deliveredStatus = $order->orderTracking->firstWhere('status', 'delivered');
        $cancelledStatus = $order->orderTracking->firstWhere('status', 'cancelled');

        $originalPrice = $order->orderItems->sum('price');
        $tax = $originalPrice * 0.10; // Pajak 10%
        $storePickup = 20; // Biaya pengambilan toko
        $totalPrice = $originalPrice + $tax + $storePickup;

        return view('dashboard.buyer.orders.order-tracking', compact(
            'order', 'originalPrice', 'tax', 'storePickup', 'totalPrice', 'user',
            'onProgressStatus', 'pendingStatus', 'shippedStatus', 'deliveredStatus', 'cancelledStatus'
        ));

        } elseif ($user->role === 'seller') {
            // Seller hanya bisa melihat order yang berisi produk dari store miliknya
            $order = Order::where('id', $id)
                ->whereHas('orderItems.product.store', function ($query) use ($user) {
                    $query->where('seller_id', $user->id); // Filter berdasarkan seller_id
                })
                ->with(['orderItems.product.store'])
                ->firstOrFail();
                
            $onProgressStatus = $order->orderTracking->firstWhere('status', 'On progress');
            $pendingStatus = $order->orderTracking->firstWhere('status', 'pending');
            $shippedStatus = $order->orderTracking->firstWhere('status', 'shipped');
            $deliveredStatus = $order->orderTracking->firstWhere('status', 'delivered');
            $cancelledStatus = $order->orderTracking->firstWhere('status', 'cancelled');

            $originalPrice = $order->orderItems->sum('price');
            $tax = $originalPrice * 0.10; // Pajak 10%
            $storePickup = 20; // Biaya pengambilan toko
            $totalPrice = $originalPrice + $tax + $storePickup;

            return view('dashboard.buyer.orders.order-tracking', compact('order','originalPrice', 'tax', 'storePickup', 'totalPrice', 'onProgressStatus', 'pendingStatus', 'shippedStatus', 'deliveredStatus', 'cancelledStatus', 'user'));

        } else {
            // Jika bukan buyer atau seller, tampilkan pesan unauthorized
            abort(403, 'Unauthorized action.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if ($user->role === 'seller') {
            $order = Order::where('id', $id)->with('orderItems')->firstOrFail();
            return view('dashboard.seller.orders.edit', compact('order'));
        } elseif($user->role === 'buyer') {

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        if ($user->role === 'seller') {
            
        } elseif($user->role === 'buyer') {

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $user = Auth::user();
    
    //     // Validasi input
    //     $request->validate([
    //         'status' => 'required|in:on progress,shipped,delivered,pending,cancelled',
    //     ]);
    
    //     $order = Order::findOrFail($id);
    
    //     if ($user->role !== 'seller') {
    //         return redirect()->back()->with('error', 'You are not authorized to perform this action.');
    //     }
    
    //     // Update status pada tabel orders
    //     $order->status = $request->status;
    //     $order->save();
    
    //     // Tambahkan log di order_tracking
    //     $order->orderTracking()->create([
    //         'status' => $request->status,
    //         'update_time' => now(),
    //     ]);
    
    //     return redirect()->back()->with('success', 'Order status updated successfully.');
    // }


    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();

        // Validasi input status
        $request->validate([
            'status' => 'required|in:on progress,shipped,delivered,pending,cancelled',
        ]);

        // Temukan order berdasarkan ID
        $order = Order::findOrFail($id);

        // Validasi apakah user memiliki role seller
        if ($user->role !== 'seller') {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        // Update status pada tabel orders
        $order->status = $request->status;
        $order->save();

        // Tambahkan log ke tabel order_tracking
        $order->orderTracking()->create([
            'status' => $request->status,
            'update_time' => now(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function cancelOrder(Request $request, $id)
    {
        $user = Auth::user();

        // Cari order berdasarkan ID dan pastikan order milik user
        $order = Order::where('id', $id)
            ->where('user_id', $user->id) // Pastikan order milik buyer tersebut
            ->firstOrFail();

        // Periksa apakah status order masih 'on progress'
        if ($order->status !== 'On progress') {
            return redirect()->back()->with('error', 'You can only cancel orders that are still "on progress".');
        }

        // Update status order menjadi 'cancelled'
        $order->status = 'cancelled';
        $order->save();

        // Tambahkan log ke tabel order_tracking jika diperlukan
        if (method_exists($order, 'orderTracking')) {
            $order->orderTracking()->create([
                'status' => 'cancelled',
                'update_time' => now(),
            ]);
        }

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Order has been successfully cancelled.');
    }

}
