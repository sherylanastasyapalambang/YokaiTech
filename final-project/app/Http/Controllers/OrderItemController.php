<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'seller') {
            // Ambil input pencarian dan filter
            $search = $request->input('search');
            $statusFilter = $request->input('status-filter');

            // Query untuk mengambil order items dari store milik seller
            $orderItems = OrderItem::with(['product', 'order'])
                ->whereHas('product', function ($query) use ($user) {
                    $query->where('store_id', $user->store->id);
                })
                ->whereHas('order', function ($query) use ($search, $statusFilter) {
                    if ($search) {
                        $query->where('id', $search);
                    }
                    if ($statusFilter) {
                        $query->where('status', $statusFilter);
                    }
                })
                ->paginate(10); // Pagination 10 data per halaman

            return view('dashboard.seller.orderItems.index', compact('orderItems', 'user'));
        } else {
            return abort(403, 'Unauthorized access');
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
