<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Query awal dengan relasi
        $query = Review::with(['user', 'product']);

        // Cek jika ada parameter pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%'); // Cari berdasarkan nama user
            })->orWhereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%'); // Cari berdasarkan nama produk
            });
        }

        // Cek jika ada filter rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Urutkan berdasarkan tanggal terbaru
        $reviews = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('dashboard.admin.reviews.index', compact('reviews'));
    } else {
        // Untuk user non-admin
        $reviews = Review::where('user_id', $user->id)
        ->orderBy('created_at', 'desc') // Bisa menggunakan created_at untuk review berdasarkan waktu pembuatan
        ->paginate(10);

        return view('dashboard.buyer.reviews.index', compact('reviews'));

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
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id', // Pastikan produk ada di tabel
            'rating' => 'nullable|integer|min:1|max:5',   // Rating hanya diperlukan untuk review utama
            'review' => 'required|string|max:1000',      // Deskripsi review/reply
            'parent_id' => 'nullable|exists:product_reviews,id', // Validasi parent_id jika ada
        ], [
            'product_id.required' => 'The product field is required.',
            'product_id.exists' => 'The selected product is invalid.',
            'rating.integer' => 'The rating field must be an integer.',
            'rating.min' => 'The rating field must be at least 1.',
            'rating.max' => 'The rating field must not exceed 5.',
            'review.required' => 'The review field is required.',
            'review.string' => 'The review field must be a string.',
            'review.max' => 'The review field must not exceed 1000 characters.',
            'parent_id.exists' => 'The selected parent review is invalid.',
        ]);
    
        // Data untuk disimpan
        $data = [
            'product_id' => $request->product_id,
            'rating' => $request->parent_id ? 0 : $request->rating, // Rating 0 jika ini adalah reply
            'review' => $request->review,
            'parent_id' => $request->parent_id, // Null jika ini review utama
            'user_id' => Auth::id(), 
        ];
        
        
        // Simpan review/reply
        Review::create($data);
    
        return redirect()->back()->with('success', 'Review or reply submitted successfully.');
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
        $user = Auth::user();
        if ($user->role === 'admin') {
            Review::where('id', $id)->delete();
            return redirect()->to('/admin/reviews')->with('success', 'Review is successfully deleted!');
        } else {
            return abort(403, 'Unauthorized action');
        }
    }
}
