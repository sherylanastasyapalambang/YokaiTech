<x-app-layout>
    <main class="md:ml-64 h-auto pt-12">

        <section class="py-8 bg-white md:py-8 antialiased">
            <h2 class="mb-4 text-xl font-semibold text-slate-900 sm:text-2xl md:mb-6 md:ml-5">Product Detail</h2>
            <hr class="my-4 md:my-4 mx-4 border-gray-300" />
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
                <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                    <img class="w-full" src="{{ Storage::url($product->image) }}" alt="" />
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
                </div>
        
                <hr class="my-6 md:my-8 border-gray-300" />
        
                <p class="mb-6 text-gray-500">
                    {{ $product->description }}
                </p>
                </div>
            </div>
            </div>
            <x-products.product-reviews 
            :action="$product"
            :product="$product" 
            :reviews="$reviews"
            :user="$user"
            />
        </section>
    </main>
</x-app-layout>