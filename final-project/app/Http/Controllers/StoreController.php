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

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Store::query();
        if ($user && $user->role === 'admin') {
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%")
                  ->orWhereHas('seller', function ($q) use ($search) {
                      $q->where('name', 'LIKE', "%$search%");
                  });
        }

        // Tambahkan eager loading dan pagination
        $stores = $query->with('seller')->paginate(10);

        foreach ($stores as $store) {
            $store->hasProduct = $store->products->isNotEmpty();
        }
        
        return view('dashboard.admin.stores.index', compact('stores'));
        } elseif ($user && $user->role === 'seller') {
            $stores = Store::where('seller_id', $user->id)->get();
            return view('dashboard.seller.stores.index', [
                'stores' => $stores,
            ]);
        } else {
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('name', 'LIKE', "%$search%")
                      ->orWhereHas('seller', function ($q) use ($search) {
                          $q->where('name', 'LIKE', "%$search%");
                      });
            }
            $stores = $query->with('seller')->get();
            foreach ($stores as $store) {
                $store->hasProduct = $store->products->isNotEmpty();
            }
           
            return view('stores.store-home', compact('stores'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $users = User::where('role', 'seller')
            ->whereDoesntHave('store') // Relasi otomatis menggunakan 'seller_id'
            ->get();
            return view('dashboard.admin.stores.create', compact('users'));
        } elseif ($user->role == 'seller') {
            if ($user->store) {
                return redirect()->route('dashboard.seller.stores.show', $user->store->slug);
            }
            return view('dashboard.seller.stores.create', compact('user'));
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

        Session::flash('seller_id', $request->seller_id);
        Session::flash('name', $request->name);
        Session::flash('description', $request->description);
        Session::flash('address', $request->address);
        Session::flash('phone', $request->phone);

        if ($user->role === 'admin') {
            $request->validate([
                'seller_id' => 'required|exists:users,id',
                'name' => 'required|string|max:255|unique:stores',
                'description' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string|digits_between:10,12',
                'storeImage' => 'nullable|image|mimes:jpeg,png,jpg,|max:2048',
            ], [
                'seller_id.required' => 'The seller field is required.',
                'seller_id.exists' => 'The selected seller is invalid.',
                'name.required' => 'Name must be filled!',
                'name.unique' => 'Name has already been taken!',
                'description.required' => 'Description must be filled!',
                'description.max' => 'Description must be less than 255 characters!',
                'address.required' => 'Address must be filled!',
                'phone.required' => 'Phone must be filled!',
                'phone.digits_between' => 'Phonenumber must be 10-12 digits!',
                'storeImage.image' => 'Store image must be a valid image file!',
                'storeImage.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
                'storeImage.max' => 'Maximum file size is 2MB!',
            ]);

            $storeImagePath = 'stores/default-storeImage.jpg';
            if ($request->hasFile('storeImage')) {
                $storeImagePath = $request->file('storeImage')->store('stores', 'public');
            }

            $data = [
                'seller_id' => $request->seller_id,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
                'storeImage' => $storeImagePath,
            ];

            Store::create($data);
            return redirect()->to('/admin/stores')->with('success', 'Store created successfully!');
            
        } elseif ($user->role === 'seller') {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'storeImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'name.required' => 'Name must be filled!',
                'description.required' => 'Description must be filled!',
                'address.required' => 'Address must be filled!',
                'phone.required' => 'Phone must be filled!',
                'storeImage.required' => 'Store image must be uploaded!',
                'storeImage.image' => 'Store image must be a valid image file!',
                'storeImage.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
                'storeImage.max' => 'Maximum file size is 2MB!',
            ]);

            $storeImagePath = 'stores/default-storeImage.jpg';
            if ($request->hasFile('storeImage')) {
                $storeImagePath = $request->file('storeImage')->store('stores', 'public');
            }

            $data = [
                'seller_id' => $user->id,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
                'storeImage' => $storeImagePath,
            ];

            Store::create($data);
            return redirect()->to('/dashboard')->with('success', 'Store created successfully.');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $store = Store::with('products')->where('slug', $slug)->firstOrFail();
        $query = Product::with(['categories', 'reviews'])
            ->withCount('reviews')
            ->withCount('reviews')->withAvg('reviews as average_rating', 'rating'); // Hitung rata-rata rating

        $categories = Category::all();
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->input('category_id'));
            });
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $product = Product::with(['categories', 'reviews'])
        ->withCount('reviews')
        ->withAvg('reviews as average_rating', 'rating')
        ->where('store_id', $store->id)
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
    
        
        $products = $query->where('store_id', $store->id)->paginate(10);

        
        $user = Auth::user();

        if (Auth::check()) {
            $favorites = Favorite::where('user_id', $user->id)->get();
        }
    
        if ($user) {
            if ($user->role === 'admin') {
                return view('stores.store-show', compact('store', 'categories', 'user', 'products', 'favorites', 'reviews'));
            } elseif ($user->role === 'seller') {
                // Pastikan seller hanya bisa melihat toko miliknya
                if ($store->seller_id !== $user->id) {
                    return abort(403, 'Unauthorized action.');
                }
                return view('stores.store-show', compact('store', 'user', 'categories', 'products', 'favorites', 'reviews'));
            } elseif ($user->role === 'buyer') {
                // Buyer bisa melihat detail store
                return view('stores.store-show', compact('store', 'categories', 'user', 'products', 'favorites', 'reviews'));
            }
        }else {
            // Guest bisa melihat detail store
            return view('stores.store-show', compact('store', 'categories', 'user', 'products'));
        }

        // Jika role tidak dikenali
        return abort(403, 'Unauthorized action.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $store = Store::where('slug', $slug)->firstOrFail();
            $users = User::where('role', 'seller')->get();
            return view('dashboard.admin.stores.edit', compact('store', 'users'));
        } elseif ($user->role === 'seller') {
             // Seller hanya dapat mengakses store miliknya sendiri
            $store = Store::where('slug', $slug)
                ->where('seller_id', $user->id) // Batasi berdasarkan seller_id
                ->first();

            if (!$store) {
                return abort(403, 'Unauthorized action.'); // Store tidak ditemukan atau bukan milik seller
            }

            $users = User::where('role', 'seller')->get();
            return view('dashboard.seller.stores.edit', compact('store', 'users'));
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

        if ($user->role === 'admin') {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('stores')->ignore($id),
                ],
                'description' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string|digits_between:10,12',
                'storeImage' => 'nullable|image|mimes:jpeg,png,jpg,|max:2048',
            ], [
               
                'name.required' => 'Name must be filled!',
                'name.unique' => 'Name has already been taken!',
                'description.required' => 'Description must be filled!',
                'description.max' => 'Description must be less than 255 characters!',
                'address.required' => 'Address must be filled!',
                'phone.required' => 'Phone must be filled!',
                'phone.digits_between' => 'Phonenumber must be 10-12 digits!',
                'storeImage.image' => 'Store image must be a valid image file!',
                'storeImage.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
                'storeImage.max' => 'Maximum file size is 2MB!',
            ]);

            // $storeImagePath = 'stores/default-storeImage.jpg';
            
            $store = Store::findOrFail($id);


            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
            ];

            if ($request->deleteStoreImage == 1) {
                // Jika tombol delete ditekan, gunakan gambar default
                $data['storeImage'] = 'stores/default-storeImage.jpg';
            } elseif ($request->hasFile('storeImage')) {
                // Simpan file baru jika ada
                $storeImagePath = $request->file('storeImage')->store('stores', 'public');
                $data['storeImage'] = $storeImagePath;
            } else {
                // Jika tidak ada perubahan pada gambar, gunakan gambar lama
                $data['storeImage'] = $store->storeImage;
            }

            Store::where('id', $id)->update($data);
        // $store->update($data);
            return redirect()->to('/admin/stores')->with('success', 'Store updated successfully!');
        } elseif ($user->role === 'seller') {
            // Validasi untuk Seller
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('stores')->ignore($id),
                ],
                'description' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string|digits_between:10,12',
                'storeImage' => 'nullable|image|mimes:jpeg,png,jpg,|max:2048',
            ], [
               
                'name.required' => 'Name must be filled!',
                'name.unique' => 'Name has already been taken!',
                'description.required' => 'Description must be filled!',
                'description.max' => 'Description must be less than 255 characters!',
                'address.required' => 'Address must be filled!',
                'phone.required' => 'Phone must be filled!',
                'phone.digits_between' => 'Phonenumber must be 10-12 digits!',
                'storeImage.image' => 'Store image must be a valid image file!',
                'storeImage.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
                'storeImage.max' => 'Maximum file size is 2MB!',
            ]);

            // Cek apakah store milik seller yang login
            $store = Store::where('id', $id)
                ->where('seller_id', $user->id)
                ->first();

            if (!$store) {
                return abort(403, 'Unauthorized action.');
            }

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
            ];

            // Update gambar jika diperlukan
            if ($request->deleteStoreImage == 1) {
                $data['storeImage'] = 'stores/default-storeImage.jpg';
            } elseif ($request->hasFile('storeImage')) {
                $storeImagePath = $request->file('storeImage')->store('stores', 'public');
                $data['storeImage'] = $storeImagePath;
            }

            $store->update($data);
            return redirect()->route('dashboard.seller.stores.show', $store->slug)->with('success', 'Store updated successfully!');

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
            Store::where('id', $id)->delete();
            return redirect()->to('/admin/stores')->with('success', 'Store Data is successfully deleted!');
        } elseif ($user->role === 'seller') {
            // Store::where('id', $id)->delete();
            // return redirect()->to('/admin/stores')->with('success', 'Store Data is successfully deleted!');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
