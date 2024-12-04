@php
    $user = auth()->user();
    $role = auth()->check() ? auth()->user()->role : 'guest';

    switch ($role) {
        case 'admin':
            $route = route('dashboard.admin.products.show', $product->slug);
            break;
        case 'seller':
            $route = route('dashboard.seller.products.show', $product->slug);
            break;
        case 'buyer':
        case 'guest': // Buyer dan guest diarahkan ke route yang sama
            $route = route('dashboard.buyer.products.show', $product->slug);
            break;
        default:
            $route = '#'; // Atur default jika role tidak valid
    }
    if(auth()->check() && $role == 'buyer') {
        $isFavorite = $favorites->contains('product_id', $product->id);
    }
@endphp    

    
    <div class="rounded-lg border p-6 shadow-sm border-slate-700 bg-slate-800">
        <div class="aspect-[4/3] w-full relative">
            <a href="{{ $route }}">
                <img class="absolute inset-0 w-full h-full object-contain max-h-56" src="{{ Storage::url($productImage) }}" alt="" />
            </a>
        </div>
        <div class="pt-1  ">
            <div class="mb-4 flex items-center justify-between gap-4">
                @if ($role == 'buyer')
                    <div class="flex items-center justify-end gap-1">
                        <button type="button" data-popover-target="tooltip-product-card-description-{{ $product->id }}"
                            class="rounded-lg p-2 text-gray-400 hover:bg-gray-700 hover:text-white">
                            <span class="sr-only"> Details </span>
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>

                        <x-popover.detail-popover 
                            :id="'tooltip-product-card-description-'.$product->id"
                            :title="'Detail Description'"
                            :content="$product->description"/>
                            
                        {{-- <div id="tooltip-product-description-{{ $product->id }}" role="tooltip"
                            class="tooltip invisible absolute z-10 inline-block rounded-lg px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 bg-gray-700"
                            data-popper-placement="top">
                            {{ $product->description }}
                            <div class="tooltip-arrow" data-popper-arrow=""></div>
                        </div> --}}


                        <form 
                            action="{{ route('dashboard.buyer.favorites.store') }}" 
                            method="POST">
                            @csrf
                            
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if(auth()->check())
                                <button
                                    {{ $isFavorite ? 'disabled' : '' }} 
                                    type="sumbit" 
                                    data-tooltip-target="tooltip-add-to-favorites{{ $product->id }}"
                                    class="rounded-lg p-2 text-gray-400 hover:bg-gray-700 hover:text-white">
                                    <span class="sr-only"> Add to Favorites </span>
                                    @if ($isFavorite)
                                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z"/>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z" />
                                        </svg>
                                    @endif
                                </button>

                                <div id="tooltip-add-to-favorites{{ $product->id }}" role="tooltip"
                                    class="tooltip invisible absolute z-10 inline-block rounded-lg px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 bg-gray-700"
                                    data-popper-placement="top">
                                    {{ $isFavorite ? 'Added to favorites' : 'Add to favorites' }}
                                    <div class="tooltip-arrow" data-popper-arrow=""></div>
                                </div>
                            @endif
                        </form>


                    </div>
                @endif
            </div>

            <a href="{{ $route }}"
                class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white h-16 overflow-hidden flex items-center justify-center text-center">
                {{ $productname }}
            </a>

            <div class="mt-2 flex items-center gap-2">
                <x-products.products-rating-stars :rating="$product->rounded_rating" />
                <span class="text-sm text-gray-500">({{ $product->reviews_count }})</span>

            </div>

            <div class="mt-4 flex flex-col items-center gap-4">
                <!-- Price -->
                <p class="text-xl font-extrabold text-gray-900 dark:text-white lg:text-2xl">
                    ${{ $productPrice }}
                </p>
        
                <!-- Conditional Button -->
                @if ($role !== 'seller' || $role !== 'admin')
                    @if ($role == 'buyer')
                        <form action="{{ route('dashboard.buyer.cartItems.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1"> <!-- Default quantity -->
                            <button type="submit" 
                                class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-medium bg-slate-100 hover:bg-slate-200">
                                <svg
                                    class="w-5 h-5 mr-2"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24">
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    @else 
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-medium bg-slate-100 hover:bg-slate-200 focus:outline-none focus:ring-4 focus:ring-slate-300">
                            <svg
                                class="w-5 h-5 mr-2"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>
                            Add to cart
                        </a>
                    @endif
                @elseif ($role == 'seller')
                    <a
                        href="{{ route('dashboard.seller.products.edit', $product->slug) }}"
                        class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-medium bg-slate-100 hover:bg-slate-200 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <svg
                            class="w-5 h-5 mr-2 text-gray-800"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                        Edit Product
                    </a>
                @endif
            </div>
        </div>
    </div>
