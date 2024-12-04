<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
    
        // Ambil keranjang milik user (instance tunggal Cart)
        $cart = $user->cart; // Relasi hasOne akan langsung memberikan instance Cart.
    
        // Ambil semua item dalam keranjang beserta informasi produk
        $cartItems = $cart->cartItems()->with('product')->get();

        // Hitung original price
        $originalPrice = $cartItems->sum('price');

        // Hitung jumlah store yang terlibat
        $uniqueStores = $cart->cartItems->map(function ($item) {
            return $item->product->store_id; // Pastikan produk memiliki relasi dengan store
        })->unique()->count();

        // Hitung biaya store pickup (misalnya $20 per store)
        $storePickup = $uniqueStores * 20;

        // Hitung tax 10% dari original price
        $tax = $originalPrice * 0.10;

        // Hitung total price
        $totalPrice = $originalPrice + $storePickup + $tax;

        // Tampilkan keranjang hanya jika user adalah buyer
        if ($user->role === 'buyer') {
            return view('dashboard.buyer.carts.index', compact('cartItems', 'user', 'cart', 'originalPrice', 'storePickup', 'tax', 'totalPrice'));
        } else {
                return abort(403, 'Unauthorized action.');
            }
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($request->product_ids as $productId) {
            $cartItem = $cart->cartItems()->firstOrCreate(
                ['product_id' => $productId],
                ['quantity' => 1, 'price' => Product::find($productId)->price]
            );

            // Increment quantity if already exists
            if (!$cartItem->wasRecentlyCreated) {
                $cartItem->increment('quantity');
            }
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
