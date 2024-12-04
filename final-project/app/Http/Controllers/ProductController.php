<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Product::with(['categories', 'reviews'])
            ->withCount('reviews')
            ->withCount('reviews')->withAvg('reviews as average_rating', 'rating'); // Hitung rata-rata rating

        $categories = Category::all();
        $stores = Store::all();

        // Filter berdasarkan peran Seller
        if ($user && $user->role === 'seller' && $user->store) {
            $query->where('store_id', $user->store->id);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->input('category_id'));
            });
        }

        // Filter berdasarkan toko
        if ($request->filled('store_id')) {
            $query->where('store_id', $request->input('store_id'));
        }

        // Filter berdasarkan pencarian nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Gunakan paginate untuk hasil yang efisien
        $products = $query->paginate(10);

        // Render view
        if ($user && $user->role === 'admin') {
            return view('dashboard.admin.products.index', compact('products', 'categories', 'stores', 'user'));
        }
        elseif ($user && $user->role === 'seller') {
            return view('dashboard.seller.products.index', compact('products', 'categories', 'stores', 'user'));
        } else {
            $user = Auth::user();
            $query = Product::with(['categories', 'reviews'])
                ->withCount('reviews')
                ->withAvg('reviews as average_rating', 'rating');
        
            $categories = Category::all();
            $stores = Store::all();
        
            // Filter berdasarkan peran Seller
            if ($user && $user->role === 'seller' && $user->store) {
                $query->where('store_id', $user->store->id);
            }
        
            // Filter berdasarkan kategori (jika ada)
            if ($request->filled('category_id') || $request->has('categories')) {
                $query->whereHas('categories', function ($q) use ($request) {
                    // Prioritaskan filter `category_id`
                    if ($request->filled('category_id')) {
                        $q->where('categories.id', $request->category_id);
                    }
                    // Tambahkan filter `categories[]` hanya jika ada
                    if ($request->has('categories')) {
                        $q->whereIn('categories.id', $request->categories);
                    }
                });
            }
            
            
        
            // Advanced Filters
            // Filter berdasarkan rentang harga
            if ($request->filled('min_price') && $request->filled('max_price')) {
                $query->whereBetween('price', [$request->min_price, $request->max_price]);
            }
        
            // Filter berdasarkan rating
            if ($request->filled('rating')) {
                $query->whereHas('reviews', function ($q) use ($request) {
                    $q->havingRaw('AVG(rating) >= ?', [$request->rating]);
                });
            }
        
            // Filter berdasarkan toko
            if ($request->filled('store_id')) {
                $query->where('store_id', $request->input('store_id'));
            }
        
            // Filter berdasarkan pencarian nama produk
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            }
        
            // Sort berdasarkan parameter
            if ($request->filled('sort_by')) {
                switch ($request->sort_by) {
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'best_selling':
                        // Gunakan relasi orderItems untuk menghitung total penjualan
                        $query->withSum('orderItems as total_sales', 'quantity') // Tambahkan kolom total_sales
                        ->orderBy('total_sales', 'desc');
                        break;
                    default:
                        $query->latest();
                }
            } else {
                $query->latest(); // Default sort
            }
        
            // Paginate hasil query
            $products = $query->paginate(12);

            if (Auth::check()) {
                $favorites = Favorite::where('user_id', $user->id)->get();
            }
        
        if ($user) {
            return view('products.products-home', compact('products', 'categories', 'stores', 'user', 'favorites'));
        } else {
            return view('products.products-home', compact('products', 'categories', 'stores', 'user'));
        }
    }
}



    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $user = Auth::user();
        if ($user->role == 'admin') {
            $stores = Store::all();
            return view('dashboard.admin.products.create', compact('stores', 'categories'));
        } elseif ($user->role == 'seller') {
            return view('dashboard.seller.products.create', compact('categories', 'user'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        Session::flash('store_id', $request->store_id);
        Session::flash('name', $request->name);
        Session::flash('description', $request->description);
        Session::flash('price', $request->price);
        Session::flash('stock', $request->stock);

        if ($user->role === 'admin') {
            $validated = $request->validate([
                'store_id' => 'required|exists:stores,id',
                'name' => 'required|max:255|unique:products',
                'categories' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
            ], [
                'store_id.required' => 'The store field is required.',
                'store_id.exists' => 'The selected store is invalid.',
                'name.required' => 'Name must be filled!',
                'name.unique' => 'You already add this product!',
                'categories.required' => 'Category must be selected!',
                'description.required' => 'Description must be filled!',
                'price.required' => 'price must be filled!',
                'price.numeric' => 'price must be a number!',
                'stock.required' => 'stock must be filled!',
                'stock.numeric' => 'stock must be a number!',
                'image.image' => 'Product image must be a valid image file!',
                'image.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
                'image.max' => 'Maximum file size is 2MB!',
                'image.required' => 'Product image must be uploaded!',
            ]);

            $productImagePath = 'products/default-productImage.jpg';
            if ($request->hasFile('image')) {
                $productImagePath = $request->file('image')->store('products', 'public');
            }

            $product = Product::create([
                'store_id' => $validated['store_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'image' => $productImagePath,
            ]);
        
            $product->categories()->sync($validated['categories']);
            return redirect()->to('/admin/products')->with('success', 'Product created successfully!');
            
        } elseif ($user->role === 'seller') {
            $validated = $request->validate([
                'store_id' => 'required|exists:stores,id',
                'name' => 'required|max:255|unique:products',
                'categories' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
            ], [
                'store_id.required' => 'The store field is required.',
                'store_id.exists' => 'The selected store is invalid.',
                'name.required' => 'Name must be filled!',
                'name.unique' => 'You already add this product!',
                'categories.required' => 'Category must be selected!',
                'description.required' => 'Description must be filled!',
                'price.required' => 'price must be filled!',
                'price.numeric' => 'price must be a number!',
                'stock.required' => 'stock must be filled!',
                'stock.numeric' => 'stock must be a number!',
                'image.image' => 'Product image must be a valid image file!',
                'image.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
                'image.max' => 'Maximum file size is 2MB!',
                'image.required' => 'Product image must be uploaded!',
            ]);

            $productImagePath = 'products/default-productImage.jpg';
            if ($request->hasFile('image')) {
                $productImagePath = $request->file('image')->store('products', 'public');
            }

            $product = Product::create([
                'store_id' => $validated['store_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'image' => $productImagePath,
            ]);
        
            $product->categories()->sync($validated['categories']);
            return redirect()->to('/seller/products')->with('success', 'Product created successfully!');
            
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::with(['categories', 'reviews'])
        ->withCount('reviews')
        ->withAvg('reviews as average_rating', 'rating')
        ->where('slug', $slug)
        ->firstOrFail();

        // Ambil parameter rating dari request
        $rating = request('rating');

        // Query ulasan berdasarkan filter rating (jika ada)
        $reviews = $product->reviews()
            ->with('user') // Memuat relasi user
            ->when($rating, function ($query, $rating) {
                $query->where('rating', $rating); // Filter berdasarkan rating jika ada
            })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->get();


        $user = Auth::user();
        $users = User::all();

        if (Auth::check()) {
            $favorites = Favorite::where('user_id', $user->id)->get();
        }
        // $favorites = Favorite::where('user_id', $user->id)->get();
        $products = Product::all();
        
        if ($user) {
            if ($user->role === 'admin') {
                $user = Auth::user();
                return view('products.product-show', compact('product', 'users', 'user', 'reviews'));
            } elseif ($user->role === 'seller') {
                return view('products.product-show', compact('product', 'users', 'user', 'reviews'));
            } else {
                return view('products.product-show', compact('product', 'users', 'user', 'reviews', 'favorites', 'products'));
            }
        } else {
            return view('products.product-show', compact('product', 'users', 'user', 'reviews', 'products'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $product = Product::where('slug', $slug)->firstOrFail();
            $stores = Store::all();
            $categories = Category::all();
            $productCategories = $product->categories->pluck('id')->toArray();
            return view('dashboard.admin.products.edit', compact('product','stores', 'categories', 'productCategories'));
        } elseif ($user->role == 'seller') {
            $product = Product::where('slug', $slug)->firstOrFail();

        if (!$product->store || $product->store->seller_id !== $user->id) {
            // Jika produk bukan milik seller yang sedang login, return 403
            return abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $productCategories = $product->categories->pluck('id')->toArray();
            return view('dashboard.seller.products.edit', compact('product', 'categories', 'productCategories', 'user'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stores')->ignore($id),
            ],
            'categories' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,|max:2048',
        ], [
            'store_id.required' => 'The store field is required.',
            'store_id.exists' => 'The selected store is invalid.',
            'name.required' => 'Name must be filled!',
            'name.unique' => 'You already add this product!',
            'categories.required' => 'Category must be selected!',
            'description.required' => 'Description must be filled!',
            'price.required' => 'price must be filled!',
            'price.numeric' => 'price must be a number!',
            'stock.required' => 'stock must be filled!',
            'stock.numeric' => 'stock must be a number!',
            'image.image' => 'Product image must be a valid image file!',
            'image.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
            'image.max' => 'Maximum file size is 2MB!',
        ]);

        // $productImagePath = 'products/default-productImage.jpg';
        $product = Product::findOrFail($id);

        if ($user->role === 'seller') {
            $store = $product->store; // Ambil store terkait
            if (!$store || $store->seller_id !== $user->id) {
                return abort(403, 'Unauthorized action.');
            }
        }
        
        $data =[
            'store_id' => $validated['store_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ];

        if ($request->deleteImage == 1) {
            // Jika tombol delete ditekan, gunakan gambar default
            $data['image'] = 'products/default-productImage.jpg';
        } elseif ($request->hasFile('image')) {
            // Simpan file baru jika ada
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        } else {
            // Jika tidak ada perubahan pada gambar, gunakan gambar lama
            $data['image'] = $product->image;
        }


        $product->update($data);
        // $product = Product::find($id); // Ambil instance model Product
        $product->categories()->sync($validated['categories']);
        
        if ($user->role === 'admin') {
            return redirect()->to('/admin/products')->with('success', 'Product updated successfully!');
        } elseif ($user->role === 'seller') {
            return redirect()->to('/seller/products')->with('success', 'Product updated successfully.');
            
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            Product::where('id', $id)->delete();
            return redirect()->to('/admin/products')->with('success', 'Product is successfully deleted!');
        } elseif ($user->role === 'seller') {
            Product::where('id', $id)->delete();
            return redirect()->to('/seller/products')->with('success', 'Product is successfully deleted!');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
