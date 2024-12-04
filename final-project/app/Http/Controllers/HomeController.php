<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();
        $stores = Store::with('seller')->get();

        $bestSales = Product::select('products.id', 'products.name', 'products.price', 'products.image', 'products.slug', DB::raw('SUM(order_items.quantity) as total_quantity'))
                ->join('order_items', 'order_items.product_id', '=', 'products.id')
                ->groupBy('products.id', 'products.name', 'products.price', 'products.image', 'products.slug')
                ->orderByDesc('total_quantity')
                ->limit(4)
                ->get();

        $topRatedProducts = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.image',
            'products.slug',
            DB::raw('AVG(product_reviews.rating) as average_rating'),
            DB::raw('COUNT(product_reviews.id) as reviews_count')
        )
            ->join('product_reviews', 'product_reviews.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.image', 'products.slug')
            ->orderByDesc('average_rating')
            ->limit(4)
            ->get();
            
            if (Auth::check()) {
                $favorites = Favorite::where('user_id', $user->id)->get();
            }
        
            
            

        if (Auth::check()) {
            if ($user->role == 'admin') {
                $user = Auth::user();
                $usersCount = User::count();
                $storesCount = Store::count();
                $productsCount = Product::count();
                $ordersCount = Order::count();

                return view('dashboard.admin.home', compact('usersCount', 'storesCount', 'productsCount', 'ordersCount', 'user'));
            } elseif ($user->role == 'seller') {
                // Ambil toko milik seller
                $store = $user->store;

                if (!$store) {
                    return view('dashboard.seller', [
                        'store' => null,
                        'ordersCount' => 0,
                        'orderedItemsCount' => 0,
                        'reviewsCount' => 0,
                        'favoritesCount' => 0,
                    ]);
                }

                // Ambil jumlah pesanan terkait toko seller
                $ordersCount = Order::whereHas('orderItems.product', function ($query) use ($store) {
                    $query->where('store_id', $store->id);
                })->count();

                // Ambil jumlah item yang dipesan terkait toko seller
                $orderedItemsCount = OrderItem::whereHas('product', function ($query) use ($store) {
                    $query->where('store_id', $store->id);
                })->sum('quantity');

                // Ambil jumlah ulasan yang terkait dengan produk toko seller
                $reviewsCount = Review::whereHas('product', function ($query) use ($store) {
                    $query->where('store_id', $store->id);
                })->count();

                // Ambil jumlah produk toko seller yang difavoritkan
                $favoritesCount = Favorite::whereHas('product', function ($query) use ($store) {
                    $query->where('store_id', $store->id);
                })->count();

                return view('dashboard.seller.home', compact('store', 'ordersCount', 'orderedItemsCount', 'reviewsCount', 'favoritesCount', 'user'));
            } elseif ($user->role == 'buyer') {
                foreach ($stores as $store) {
                    $store->hasProduct = $store->products->isNotEmpty();
                }
                // Mendapatkan 4 produk dengan total quantity terbesar
                return view('dashboard.buyer.home', compact('categories', 'bestSales', 'topRatedProducts', 'user', 'favorites', 'stores'));
            }
        } else {
            foreach ($stores as $store) {
                $store->hasProduct = $store->products->isNotEmpty();
            }
            return view('welcome', compact('categories', 'bestSales', 'topRatedProducts', 'user', 'stores'));
        }
    }

}
