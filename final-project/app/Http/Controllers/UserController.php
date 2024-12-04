<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
    
        $query = User::query();
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
    
        if ($role) {
            $query->where('role', $role);
        }
    
        // Paginate data
        $users = $query->paginate(10);
    
        // Append query string manually
        $users->appends([
            'search' => $search,
            'role' => $role,
        ]);
    
        return view('dashboard.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);
        Session::flash('password', $request->password);
        Session::flash('role', $request->role);
        Session::flash('address', $request->address);
        Session::flash('phone', $request->phone);
        

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'address' => 'required',
            'phone' => 'required|digits_between:10,12',
            'profileImage' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Name must be filled!',
            'email.required' => 'Email must be filled!',
            'email.email' => 'Invalid email format!',
            'email.unique' => 'Email already exists!',
            'password.required' => 'Password must be filled!',
            'password.min' => 'Password must be at least 8 characters!',
            'role.required' => 'Role must be selected!',
            'address.required' => 'Address must be filled!',
            'phone.required' => 'Phone must be filled!',
            'phone.digits' => 'Phone must be 10-12 digits!',
            'profileImage.image' => 'Profile Image must be a valid image file!',
            'profileImage.mimes' => 'Only jpeg, png, dan jpg formats are allowed!',
            'profileImage.max' => 'Maximum file size is 2MB!',
            'profileImage.required' => 'Profile Image must be filled!',
        ]);

        $profileImagePath = 'profile/default-profileImage.jpg';
        if ($request->hasFile('profileImage')) {
            $profileImagePath = $request->file('profileImage')->store('profile', 'public');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'address' => $request->address,
            'phone' => $request->phone,
            'profileImage' => $profileImagePath,
        ];

        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->to('/admin/users')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->first();
        
        if ($user->role === 'admin') {
            return view('profileDetail.show', compact('user'));
        } elseif ($user->role === 'seller') {
            return view('profileDetail.show', compact('user'));
        } elseif ($user->role === 'buyer') {
            // Menghitung jumlah orders
            $ordersCount = $user->orders()->count();

            // Menghitung jumlah reviews yang ditambahkan
            $reviewsCount = $user->reviews()->count();

            // Menghitung jumlah produk favorit yang ditambahkan
            $favoritesCount = $user->favorites()->count();

            return view('profileDetail.show', compact('user', 'ordersCount', 'reviewsCount', 'favoritesCount'));
        } else {
            return abort(404, 'User not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loginUser = Auth::user();
        $user = User::where('id', $id)->first();

        if ($loginUser->role === 'admin' && $user) {
            return view('dashboard.admin.users.edit', compact('user'));
        } elseif ($loginUser->role === 'seller' && $user) {
            return view('dashboard.seller.profile-edit', compact('user'));
        } elseif ($loginUser->role === 'buyer' && $user) {
            // Menghitung jumlah orders
            $ordersCount = $user->orders()->count();

            // Menghitung jumlah reviews yang ditambahkan
            $reviewsCount = $user->reviews()->count();

            // Menghitung jumlah produk favorit yang ditambahkan
            $favoritesCount = $user->favorites()->count();
            return view('dashboard.buyer.profile-edit', compact('user', 'ordersCount', 'reviewsCount', 'favoritesCount'));
        } else {
            return abort(404, 'User not found!');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'phone' => 'required|digits_between:10,12',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Name must be filled!',
            'email.required' => 'Email must be filled!',
            'email.email' => 'Invalid email format!',
            'email.unique' => 'Email already exists!',
            'address.required' => 'Address must be filled!',
            'phone.required' => 'Phone must be filled!',
            'phone.digits' => 'Phone must be 10-12 digits!',
            'profileImage.image' => 'Profile Image must be a valid image file!',
            'profileImage.mimes' => 'Only jpeg, png, and jpg formats are allowed!',
            'profileImage.max' => 'Maximum file size is 2MB!',
        ]);
    
        // Ambil data user dari database
        $user = User::findOrFail($id);
    
        // Siapkan data yang akan diperbarui
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ];
    
        if ($request->deleteProfileImage == 1) {
            // Jika tombol delete ditekan, gunakan gambar default
            $data['profileImage'] = 'profile/default-profileImage.jpg';
        } elseif ($request->hasFile('profileImage')) {
            // Simpan file baru jika ada
            $profileImagePath = $request->file('profileImage')->store('profile', 'public');
            $data['profileImage'] = $profileImagePath;
        } else {
            // Jika tidak ada perubahan pada gambar, gunakan gambar lama
            $data['profileImage'] = $user->profileImage;
        }
    
        // Update data user
        $user->update($data);

        $loginUser = Auth::user();

        if ($loginUser->role === 'admin') {
            return redirect()->to('/admin/users')->with('success', 'User Data is successfully updated!');
        } elseif ($loginUser->role === 'seller') {
            return redirect()->to('seller/user/' . $id)->with('success', 'User Data is successfully updated!');
        } elseif ($loginUser->role === 'buyer') {
            return redirect()->to('buyer/user/' . $id)->with('success', 'User Data is successfully updated!');
        } else {
            return abort(404, 'User not found!');
        }
        
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
        return redirect()->to('/admin/users')->with('success', 'User Data is successfully deleted!');
    }
}
