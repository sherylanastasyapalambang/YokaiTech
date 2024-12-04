@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <main class="p-1 md:ml-64 h-auto pt-20">
        <section class="bg-gray-50 py-3 sm:py-5">
            <div class="px-4 mx-auto max-w-screen-2xl">
                <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                    <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="w-full md:w-2/3">
                            <form method="GET" class="flex flex-col lg:flex-row lg:items-center space-y-3 lg:space-y-0 lg:space-x-4">
                                @csrf
                                <div class="relative w-full lg:w-56">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" id="simple-search" name="search"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Search" value="{{ request('search') }}">
                                    </div>
                                </div>
                    
                                <!-- Select Category -->
                                <div class="w-full lg:w-32">
                                    <label for="category" class="sr-only">Category</label>
                                    <select id="category" name="category_id" onchange="this.form.submit()"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    
                        <!-- Add Product Button -->
                        <div class="w-full md:w-auto flex justify-end">
                            <a href="{{ route('dashboard.seller.products.create') }}"
                                class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Add Product
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Product</th>
                                    <th scope="col" class="pl-10 px-4 py-3">Category</th>
                                    <th scope="col" class="px-4 py-3">Description</th>
                                    <th scope="col" class="px-4 py-3">Stock</th>
                                    <th scope="col" class="px-4 py-3">Price</th>
                                    <th scope="col" class="px-4 py-3">Rating</th>
                                    <th scope="col" class="px-4 py-3">Last Update</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($products as $product)
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <th scope="row" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <img src="{{ Storage::url($product->image) }}" alt="product Image" class="w-auto h-8 mr-3">
                                        <a href="{{ route('dashboard.seller.products.show', $product->slug) }}" class="hover:underline">{{ $product->name }}</a>
                                    </th>
                                    
                                    <td class="pl-10 px-4 py-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $product->categories->pluck('name')->implode(', ') }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      <a href="#" data-popover-target="product-detail-description-{{ $product->id }}" class="underline">{{ Str::words($product->description, 3, '...') }}</a>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            <div class="inline-block w-4 h-4 mr-2 rounded-full 
                                                @if ($product->stock < 50) 
                                                    bg-red-700 
                                                @elseif ($product->stock >= 50 && $product->stock < 100) 
                                                    bg-yellow-500 
                                                @else 
                                                    bg-green-500 
                                                @endif">
                                            </div>
                                            {{ $product->stock }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        ${{ $product->price }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items">
                                            <x-products.products-rating-stars :rating="$product->rounded_rating" />
                                            <span class="text-sm text-gray-500">({{ $product->reviews_count }})</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ $product->updated_at }}
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="product-dropdown-{{ $product->id }}-button"
                                            data-dropdown-toggle="product-dropdown-{{ $product->id }}"
                                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                            type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="product-dropdown-{{ $product->id }}"
                                            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="product-dropdown-{{ $product->id }}-button">
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('dashboard.seller.products.edit', $product->slug) }}"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li>
                                            </ul>
                                            <div class="py-1">
                                                <button 
                                                    data-modal-target="delete-product-{{ $product->id }}" 
                                                    data-modal-toggle="delete-product-{{ $product->id }}"
                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <x-popover.detail-popover 
                                    :id="'product-detail-description-'.$product->id"
                                    :title="'Detail Description'"
                                    :content="$product->description"/>

                                <x-modals.delete-modal 
                                    :id="'delete-product-'.$product->id" 
                                    :entity="'product'" 
                                    :action="route('dashboard.seller.products.destroy', $product->id)" />
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
