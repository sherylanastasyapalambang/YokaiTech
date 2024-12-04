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
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="search" name="search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Search by user or product" value="{{ request('search') }}">
                                </div>
                            </div>
                        
                            <!-- Filter Rating -->
                            <div class="w-full lg:w-32">
                                <label for="rating" class="sr-only">Rating</label>
                                <select id="rating" name="rating" onchange="this.form.submit()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">All Ratings</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </form>
                    </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">User</th>
                                    <th scope="col" class="pl-10 px-4 py-3">Product</th>
                                    <th scope="col" class="px-4 py-3">Rating</th>
                                    <th scope="col" class="px-4 py-3">Review</th>
                                    <th scope="col" class="px-4 py-3">Date</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($reviews as $review)
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ $review->user->name }}
                                    </td>
                                    
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ $review->product->name }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      <div class="flex items-center">
                                        <x-products.products-rating-stars :rating="$review->rating" />
                                      </div>
                                    </td>

                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      <a href="#" data-popover-target="review-detail-description-{{ $review->id }}" class="underline">{{ Str::words($review->review, 5, '...') }}</a>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $review->updated_at }}
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="review-dropdown-{{ $review->id }}-button"
                                            data-dropdown-toggle="review-dropdown-{{ $review->id }}"
                                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                            type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="review-dropdown-{{ $review->id }}"
                                            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="review-dropdown-{{ $review->id }}-button">
                                                <li>
                                                    <a href="{{ route('dashboard.admin.products.show', $review->Product->slug) }}"
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Go to product detail</a>
                                                </li>
                                            </ul>
                                            <div class="py-1">
                                                <button 
                                                    data-modal-target="delete-review-{{ $review->id }}" 
                                                    data-modal-toggle="delete-review-{{ $review->id }}"
                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <x-popover.detail-popover 
                                    :id="'review-detail-description-'.$review->id"
                                    :title="'Detail Description'"
                                    :content="$review->review"/>

                                <x-modals.delete-modal 
                                    :id="'delete-review-'.$review->id" 
                                    :entity="'review'" 
                                    :action="route('dashboard.admin.reviews.destroy', $review->id)" />
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
