<x-app-layout>
    <main class="p-4 h-auto pt-2 antialiased">
        <form method="GET" action="{{ route('products.index') }}">
            @csrf
        <section class="py-4  md:py-12">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <!-- Heading & Filters -->
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <div class="relative w-full lg:w-96 md:w-auto sm:w-auto">
                        <label for="simple-search" class="sr-only">Search </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                                onchange="this.form.submit()"
                                type="text" 
                                id="simple-search" 
                                name="search"
                                value="{{ request('search') }}" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search Product Name">
                            
                        </div>
                    </div>
                  
                <div class="flex items-center space-x-4">
                    <button data-modal-toggle="filterModal" data-modal-target="filterModal" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
                      <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                      </svg>
                      Filters
                      <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                      </svg>
                    </button>
                    
                        <div class="sm:w-auto">
                            <label for="sort_by" class="sr-only">Sort</label>
                            <select name="sort_by" id="sort_by" onchange="this.form.submit()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="best_selling" {{ request('sort_by') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                            </select>
                        </div>
                    <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-200 bg-white px-5 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Reset</a>
                  </div>
                </div>
              </div>


            {{-- Products --}}
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($products as $product)
                    @if ($user)
                        <x-products.product-card 
                            :productname="$product->name" 
                            :productImage="$product->image"
                            :productPrice="$product->price" 
                            :rating="$product->rounded_rating" 
                            :count="$product->reviews_count" 
                            :user="$user" 
                            :product="$product"
                            :favorites="$favorites"/>
                    @else
                        <x-products.product-card 
                            :productname="$product->name" 
                            :productImage="$product->image"
                            :productPrice="$product->price" 
                            :rating="$product->rounded_rating" 
                            :count="$product->reviews_count" 
                            :user="$user" 
                            :product="$product"/>
                    @endif
                @empty
                        <div class="mx-auto grid max-w-screen-xl  md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-16 xl:gap-16">
                        <div class="lg:col-span-5 lg:mt-0">
                            <a href="#">
                            <img class="mb-4 hidden dark:block md:h-full" src="{{ Storage::url('/yokaitech-images/no-product.png') }}" alt="peripherals" />
                            </a>
                        </div>
                        <div class="me-auto place-self-center lg:col-span-7">
                            <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-4xl">
                            We don't have the product:(
                            </h1>
                            <p class="mb-6 text-gray-500 ">Oops! Looks like our shelves are empty. Try changing your filters or search for something else. Maybe the products are hiding from you!</p>
                        </div>
                        </div>
                @endforelse
              </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>

            {{-- modal --}}
            <!-- Filter modal -->
            <div id="filterModal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-modal w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0 md:h-full">
                <div class="relative h-full w-full max-w-xl md:h-auto">
                  <!-- Modal content -->
                  <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between rounded-t p-4 md:p-5">
                      <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Filters</h3>
                      <button type="button" class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="filterModal">
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                      </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-4 md:px-5">
                      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                          <li class="mr-1" role="presentation">
                            <button class="inline-block pb-2 pr-1" id="brand-tab" data-tabs-target="#brand" type="button" role="tab" aria-controls="profile" aria-selected="false">
                              Category
                          </button>
                          </li>
                          <li class="mr-1" role="presentation">
                            <button class="inline-block px-2 pb-2 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300" id="advanced-filers-tab" data-tabs-target="#advanced-filters" type="button" role="tab" aria-controls="advanced-filters" aria-selected="false">Advanced Filters</button>
                          </li>
                        </ul>
                      </div>

                        @if (request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif

                      <div id="myTabContent">
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                          <div class="space-y-2">
                            @foreach ($categories as $category)
                            <div class="flex items-center">
                              <input 
                                id="category-dropdown{{ $category->id }}" 
                                type="checkbox" 
                                name="categories[]"
                                value="{{ $category->id }}" 
                                {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600" />
            
                              <label for="category-dropdown{{ $category->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"> {{ $category->name }} </label>
                            </div>
                            @endforeach
                          </div> 
                        </div>
                      </div>
            
                      <div class="space-y-4" id="advanced-filters" role="tabpanel" aria-labelledby="advanced-filters-tab">
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                          <div class="grid grid-cols-2 gap-3">
                              <h3 class="text-lg text-gray-400">Price Range</h3>
                            <div class="col-span-2 flex items-center justify-between space-x-2">
                              <input 
                                type="number" 
                                id="min-price-input" 
                                name="min_price"
                                value="{{ request('min_price') }}" 
                                placeholder="Min Price"
                                min="0" 
                                max="10000" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 " placeholder="" />
                              <div class="shrink-0 text-sm font-medium dark:text-gray-300">to</div>
                              <input 
                                type="number" 
                                id="max-price-input" 
                                name="max_price"
                                value="{{ request('max_price') }}"
                                placeholder="Max Price"
                                min="0" 
                                max="10000" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" placeholder="" />
                            </div>
                          </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                          <div>
                            <h6 class="mb-2 text-sm font-medium text-black dark:text-white">Rating</h6>
                            <div class="space-y-2">
                                @for ($i = 5; $i >= 1; $i--)
                                    <div class="flex items-center">
                                        <input 
                                            id="{{ $i }}-stars" 
                                            type="radio" 
                                            value="{{ $i }}" 
                                            name="rating" 
                                            {{ request('rating') == $i ? 'checked' : '' }}
                                            class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600" />
                                        <label for="{{ $i }}-stars" class="ml-2 flex items-center">
                                        <svg aria-hidden="true" class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-gray-500">{{ $i }} stars & up</span>                                
                                        </label>
                                    </div>
                                @endfor
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
            
                    <!-- Modal footer -->
                    <div class="flex items-center space-x-4 rounded-b p-4 dark:border-gray-600 md:p-5">
                      <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">Show results</button>
                    </div>
                  </div>
                </div>
                </div>
            </section>
        </form>
    </main>
</x-app-layout>