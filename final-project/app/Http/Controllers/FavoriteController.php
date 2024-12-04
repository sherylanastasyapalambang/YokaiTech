<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mendapatkan semua kategori untuk dropdown filter
        $categories = Category::all();

        // Query untuk mendapatkan favorit berdasarkan user yang sedang login
        $query = Favorite::with(['product.categories'])
            ->where('user_id', Auth::id());

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->whereHas('product.categories', function ($q) use ($request) {
                $q->where('categories.id', $request->input('category_id'));
            });
        }

        // Pencarian berdasarkan nama produk
        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('search') . '%');
            });
        }

        // Mendapatkan semua data favorit
        $favorites = $query->get();

        return view('dashboard.buyer.favorites.index', compact('favorites', 'categories'));
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
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
        ]);

        if ($favorite->wasRecentlyCreated) {
            return redirect()->back()->with('success', 'Product added to favorites.');
        }

        return redirect()->back()->with('info', 'Product is already in favorites.'); 
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
    public function destroy($id)
    {
        try {
            $user = Auth::user();
    
            // Temukan favorite berdasarkan user_id dan product_id
            $favorite = Favorite::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

    
            // Hapus favorite
            $favorite->delete();
    
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Product removed from favorites.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect dengan pesan error jika favorite tidak ditemukan
            return redirect()->back()->with('error', 'Product not found in favorites.');
        }
    }
    
}
