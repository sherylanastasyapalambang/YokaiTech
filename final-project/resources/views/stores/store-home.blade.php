<x-app-layout>
    <section >
        <div class="py-4 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-6 ">
            <div class="mx-auto max-w-screen-sm text-center mb-3 lg:mb-6">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 ">Stores</h2>
                <form method="GET">
                    @csrf
                    <div class="lg:w-96 ml-28 w-full sm:w-56">
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
                </form>
            </div> 
            <div class="grid gap-3 mb-6 lg:mb-16 md:grid-cols-2">
                @forelse ($stores as $store)
                    @if ($store->hasProduct) 
                        <div class="items-center rounded-lg shadow sm:flex bg-gray-800 border-gray-700">
                            <a href="{{ route('stores.show', $store->slug) }}" class="flex-shrink-0">
                            <img 
                                class="w-40 h-4w-40 rounded-lg object-cover sm:rounded-none sm:rounded-l-lg" 
                                src="{{ Storage::url($store->storeImage) }}" 
                                alt="Bonnie Avatar">
                            </a>
                            <div class="p-5">
                                <h3 class="text-xl font-bold tracking-tight text-white hover:underline">
                                    <a href="{{ route('stores.show', $store->slug) }}">{{ $store->name }}</a>
                                </h3>
                                <span class="text-gray-400">by {{ $store->Seller->name }}</span>
                                <p class="mt-3 mb-4 font-light text-gray-400">{{ Str::words($store->description, 6, '...') }}</p>
                            </div>
                        </div> 
                    @endif
                @empty
                    <div class="mx-auto grid max-w-screen-xl  md:p-8 lg:grid-cols-12 lg:gap-8 xl:gap-16">
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
        </div>
      </section>
</x-app-layout>