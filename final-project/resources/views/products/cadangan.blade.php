<x-app-layout>
    <section class="py-8 bg-white md:py-8 antialiased">
        <h2 class="mb-4 text-xl font-semibold text-slate-900 sm:text-2xl md:mb-6 md:ml-5">Product Detail</h2>
        <hr class="my-4 md:my-4 mx-4 border-gray-300" />
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
          <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                <img class="w-full" src="/images/asus-zenbook-14-pro.png" alt="" />
            </div>
    
            <div class="mt-6 sm:mt-8 lg:mt-0">
              <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl"
              >
                {{ $product->name }}
              </h1>
              <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                <p
                  class="text-2xl font-extrabold text-gray-900 sm:text-3xl"
                >
                  ${{ $product->price }}
                </p>
    
                <div class="flex items-center gap-2 mt-2 sm:mt-0">
                  <div class="flex items-center gap-1">
                    <x-products.products-rating-stars 
                      :rating="$product->rounded_rating" 
                    />
                  </div>
                  <a
                    href="#"
                    class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline"
                  >
                  {{ $product->reviews_count }} Reviews
                  </a>
                </div>
                
              </div>
                <div class="mt-4">
                    <div class="flex items-center gap-1 mt-1 text-slate-500">
                    <svg class="hidden h-6 w-6 shrink-0 text-slate-400 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z"/>
                    </svg>
                    <a href="" class="text-lg hover:underline">by {{ $product->Store->name }}</a> 
                    </div>

                    <div class="flex items-center gap-1 mt-2 text-slate-500">
                    <svg class="hidden h-6 w-6 shrink-0 text-slate-400 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 7h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C10.4 2.842 8.949 2 7.5 2A3.5 3.5 0 0 0 4 5.5c.003.52.123 1.033.351 1.5H4a2 2 0 0 0-2 2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2Zm-9.942 0H7.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM13 14h-2v8h2v-8Zm-4 0H4v6a2 2 0 0 0 2 2h3v-8Zm6 0v8h3a2 2 0 0 0 2-2v-6h-5Z"/>
                    </svg>
                    <p class="text-lg">{{ $product->stock }} items</p> 
                    </div>
                </div>
    
              <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                @if ($user->role == 'seller')
                    <a
                    href="{{ route('dashboard.seller.products.edit', $product->slug) }}"
                    title=""
                    class="text-white mt-4 sm:mt-0 bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none flex items-center justify-center"
                    role="button"
                    >
                    <svg class="mr-3 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                    </svg>
                    Edit Product
                    </a>
                @elseif ($user->role !== 'admin')
                    <a
                        href="#"
                        title=""
                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-red-600 hover:text-white focus:z-10 focus:ring-4 focus:ring-redbg-red-600"
                        role="button"
                    >
                        <svg
                        class="w-5 h-5 -ms-2 me-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                        >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"
                        />
                        </svg>
                        Add to favorites
                    </a>
        
                    <a
                        href="#"
                        title=""
                        class="text-white mt-4 sm:mt-0 bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none flex items-center justify-center"
                        role="button"
                    >
                        <svg
                        class="w-5 h-5 -ms-2 me-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                        >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6"
                        />
                        </svg>
                        Add to cart
                    </a>
                @endif
              </div>
    
              <hr class="my-6 md:my-8 border-gray-300" />
    
              <p class="mb-6 text-gray-500">
                {{ $product->description }}
              </p>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-gray-100 py-8 antialiased md:py-14">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
          <div class="flex flex-wrap items-center gap-4">
            <!-- Bagian Reviews -->
            <div class="flex items-center gap-2">
              <h2 class="text-2xl font-semibold text-gray-900">Reviews</h2>
              <div class="mt-2 flex items-center gap-2 sm:mt-0">
                <div class="flex items-center gap-0.5">
                  <x-products.products-rating-stars 
                    :rating="$product->rounded_rating" 
                    />
                </div>
                <a href="#" class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline">{{ $product->reviews_count }} Reviews</a>
              </div>
            </div>
        
            <!-- Bagian Category dan Write a Review -->
            <div class="flex flex-col items-start sm:flex-row sm:items-center sm:gap-4 sm:ml-auto w-full sm:w-auto">
              <div class="w-full sm:w-auto">
                <label for="rating" class="sr-only">Rating</label>
                <select id="rating" name="rating" onchange="this.form.submit()"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2">
                  <option value="">All Ratings</option>
                  @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                  @endfor
                </select>
              </div>
              {{-- @if ($user->role !== 'admin' && $user->role !== 'seller') --}}
                <button type="button" data-modal-target="review-modal" data-modal-toggle="review-modal" class="mt-2 sm:mt-0 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">
                  Write a review
                </button>
              {{-- @endif --}}
            </div>
          </div>
        
      
          <div class="mt-6 divide-y divide-gray-200">
            <div class="gap-3 pb-6 sm:flex sm:items-start">
              <div class="shrink-0 space-y-2 sm:w-48 md:w-72">
                <div class="flex items-center gap-0.5">
                  <x-products.products-rating-stars :rating="$product->rounded_rating" />
                </div>
      
                <div class="space-y-0.5">
                  <p class="text-base font-semibold text-gray-900 ">{{ $firstReview->user->name }}</p>
                  <p class="text-sm font-normal text-gray-500 ">{{ $product->Review->updated_at }}</p>
                </div>          
              </div>
      
              <div class="mt-4 min-w-0 flex-1 space-y-4 sm:mt-0">
                <p class="text-base font-normal text-gray-500 ">
                  {{ $product->Review->review }}
                </p>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </section>
      
      <!-- Add review modal -->
      <div id="review-modal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 antialiased">
        <div class="relative max-h-full w-full max-w-2xl p-4">
          <!-- Modal content -->
          <div class="relative rounded-lg bg-white shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 ">
              <div>
                <h3 class="mb-1 text-lg font-semibold text-gray-900 ">Add a review for:</h3>
                <p href="#" class="font-medium text-blue-700">{{ $Review->Product->name }}</p>
              </div>
              <button type="button" class="absolute right-5 top-5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 " data-modal-toggle="review-modal">
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
              @csrf
              <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="col-span-2">
                  <div class="flex items-center">
                    <svg class="h-6 w-6 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="ms-2 h-6 w-6 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="ms-2 h-6 w-6 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="ms-2 h-6 w-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="ms-2 h-6 w-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <span class="ms-2 text-lg font-bold text-gray-900 ">3.0 out of 5</span>
                  </div>
                </div>
                <div class="col-span-2">
                  <label for="description" class="mb-2 block text-sm font-medium text-gray-900 ">Review description</label>
                  <textarea id="description" rows="6" class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 " required=""></textarea>
                </div>
              </div>
              <div class="border-t border-gray-200 pt-4 md:pt-5">
                <button type="submit" class="me-2 inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 ">Add review</button>
                <button type="button" data-modal-toggle="review-modal" class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 ">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
</x-app-layout>