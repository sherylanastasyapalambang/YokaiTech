<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); 

        $cartItems = CartItem::with('product')->get();

        // Hitung original price
        $originalPrice = $cartItems->sum('price');

        // Hitung jumlah store yang terlibat
        $uniqueStores = $cartItems->map(function ($item) {
            return $item->product->store_id; // Pastikan produk memiliki relasi dengan store
        })->unique()->count();

        // Hitung biaya store pickup (misalnya $20 per store)
        $storePickup = $uniqueStores * 20;

        // Hitung tax 10% dari original price
        $tax = $originalPrice * 0.10;

        // Hitung total price
        $totalPrice = $originalPrice + $storePickup + $tax;

        if ($user->role === 'buyer') {
            return view('dashboard.buyer.carts.checkout', compact('cartItems', 'user', 'originalPrice', 'storePickup', 'tax', 'totalPrice'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
        
    }

    public function increment(CartItem $cartItem)
    {
        $cartItem->quantity += 1;
        $cartItem->price = $cartItem->quantity * $cartItem->Product->price; // Menghitung ulang total harga
        $cartItem->save();
    
        return redirect()->route('dashboard.buyer.carts.index')->with('success', 'Item quantity updated.');
    }
    
    public function decrement(CartItem $cartItem)
    {
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->price = $cartItem->quantity * $cartItem->Product->price; // Menghitung ulang total harga
            $cartItem->save();
    
            return redirect()->route('dashboard.buyer.carts.index')->with('success', 'Item quantity updated.');
        }
    
        return redirect()->route('dashboard.buyer.carts.index')->with('error', 'Quantity cannot be less than 1.');
    }
    

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('dashboard.buyer.carts.index')->with('success', 'Item removed from cart.');
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
    public function store(Request $request)
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Pastikan user memiliki role buyer
        if ($user->role !== 'buyer') {
            return response()->json(['message' => 'Hanya buyer yang dapat menambahkan produk ke keranjang'], 403);
        }

        // Cari atau buat keranjang untuk user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Cek apakah produk sudah ada di cart_items
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Jika produk sudah ada, tambahkan jumlahnya
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Jika produk belum ada, tambahkan sebagai item baru
            $product = Product::findOrFail($request->product_id);
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
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
