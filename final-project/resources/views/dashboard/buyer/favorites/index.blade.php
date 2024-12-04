<x-app-layout>
    <main class="h-auto pt-5">
        <section class="bg-white antialiased ">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="flex flex-wrap items-center justify-between gap-4">

                    <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Your Favourites</h2>
                      
                    <div class="w-full sm:w-auto flex items-center gap-4">
                      <form method="GET" class="w-full flex items-center gap-4">
                          @csrf
                          <div class="w-full sm:w-56">
                              <label for="category" class="sr-only">Category</label>
                              <select id="category" name="category_id" onchange="this.form.submit()"
                                  class="text-sm rounded-lg border dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 block w-full p-2">
                                  <option value="">All Categories</option>
                                  @foreach ($categories as $category)
                                      <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                          {{ $category->name }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                  
                          <!-- Search Input -->
                          <div class="w-full sm:w-56">
                              <label for="simple-search" class="sr-only">Search</label>
                              <div class="relative">
                                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                      <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                          <path fill-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                              clip-rule="evenodd" />
                                      </svg>
                                  </div>
                                  <input type="text" id="simple-search" name="search"
                                      class="bg-gray-50 border text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 block w-full pl-10 p-2"
                                      placeholder="Search" value="{{ request('search') }}">
                              </div>
                          </div>
                      </form>
                    </div>
                </div>
              <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                  <div class="space-y-6">
                    <div class="rounded-lg border p-4 shadow-sm border-gray-700 bg-gray-800 md:p-6">
                        <form method="POST" action="{{ route('cart.add') }}" id="favorite-form">
                            @csrf
                            <ul>
                                @forelse ($favorites as $favorite)
                                <li class="mb-2">
                                    <input 
                                        type="checkbox" 
                                        id="product-{{ $favorite->Product->id }}" 
                                        name="product_ids[]" 
                                        value="{{ $favorite->Product->id }}" 
                                        value="" 
                                        class="hidden peer">
                                    <label 
                                        for="product-{{ $favorite->Product->id }}" 
                                        class="inline-flex  w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class=" space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <a href="#" class="shrink-0 md:order-1">
                                            <img class="h-16 w-h-16 block" src="{{ Storage::url($favorite->Product->image) }}" alt="imac image" />
                                        </a>
                                        <div class="flex items-center justify-between md:order-3 md:justify-end xl:ml-72 md:ml-72">
                                            <div class="text-end md:order-4 md:w-32">
                                            <p class="text-base font-bold text-white">${{$favorite->Product->price}}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <a href="{{ route('dashboard.buyer.products.show', $favorite->Product->slug) }}" class="text-base font-medium hover:underline text-white">
                                            {{$favorite->Product->name}}
                                            </a>
                                            <div class="flex items-center gap-4">
                                            <a href="{{ route('dashboard.buyer.stores.show', $favorite->Product->Store->slug) }}" 
                                                class="inline-flex items-center mr-10 text-sm font-medium  hover:underline text-gray-400 hover:text-white">
                                                <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z"/>
                                                </svg>
                                                {{$favorite->Product->Store->name}}
                                            </a>
                            
                                            <button 
                                                type="button" 
                                                onclick="removeFavorite('{{ route('favorites.remove', ['id' => $favorite->id]) }}')"
                                                class="inline-flex items-center text-sm font-medium hover:underline text-red-500">
                                                <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                                </svg>
                                                Remove
                                            </button>
                                            </div>
                                        </div>
                                        </div>
                                    </label>
                                </li>
                                @empty
                                <li class="mb-2">
                                    <label class="justify-center inline-flex  w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <p class=" font-medium hover:underline text-white">
                                            No favourite items yet:(
                                            </p>
                                        </div>
                                        </div>
                                    </label>
                                </li>
                                @endforelse
                            </ul>
                            <button 
                                type="submit" 
                                id="add-to-cart-button" 
                                class="hidden mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Add to cart
                            </button>
                        </form>

                        <form method="POST" id="delete-favorite-form" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </section>
    </main>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const addToCartButton = document.getElementById('add-to-cart-button');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const isChecked = Array.from(checkboxes).some(cb => cb.checked);
                addToCartButton.classList.toggle('hidden', !isChecked);
            });
        });
    });

    function removeFavorite(actionUrl) {
        const form = document.getElementById('delete-favorite-form');
        form.action = actionUrl;
        form.submit();
    }
</script>