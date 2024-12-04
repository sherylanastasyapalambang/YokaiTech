@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
  <main class="p-4 h-auto pt-2">
    <div class="grid grid-cols-4 gap-4 mb-4">
      <!-- Kolom sebelah kiri yang merupakan rowspan -->
      <div class=" bg-slate-800 shadow-md shadow-slate-500 rounded-lg h-full row-span-2 p-3">
        @php $count = 0; @endphp
        @foreach ($categories as $category)
            @if ($count >= 12) @break @endif
            <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="flex items-center rounded-lg px-4 py-2 bg-slate-800 hover:bg-gradient-to-r hover:from-slate-800 hover:to-slate-600 transition-all">
                <span class="text-base font-medium text-white">{{ $category->name }}</span>
            </a>
            @php $count++; @endphp
        @endforeach
          <a href="{{ route('products.index')}}" title="" class=" px-4 py-2 flex items-center text-base font-medium text-slate-300 hover:text-blue-600">
            See more categories
            <svg class="ms-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
          </a>
        
      </div>
      
      <div id="carousel" class="col-span-3 rounded-lg h-64 mb-2">
        <div id="controls-carousel" class="relative w-full h-full" data-carousel="slide">
          <!-- Carousel wrapper -->
          <div class="relative w-full h-full overflow-hidden rounded-lg z-0">
              <!-- Item 1 -->
              <div class="hidden duration-700 ease-in-out" data-carousel-item>
                  <img src="{{ Storage::url("yokaitech-images/banner-1.png") }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Banner 1">
              </div>
              <!-- Item 2 -->
              <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                  <img src="{{ Storage::url("yokaitech-images/banner-2.png") }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Banner 2">
              </div>
              <!-- Item 3 -->
              <div class="hidden duration-700 ease-in-out" data-carousel-item>
                  <img src="{{ Storage::url("yokaitech-images/banner-3.png") }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Banner 3">
              </div>
              <!-- Item 4 -->
              <div class="hidden duration-700 ease-in-out" data-carousel-item>
                  <img src="{{ Storage::url("yokaitech-images/banner-4.png") }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Banner 4">
              </div>
              <!-- Item 5 -->
              <div class="hidden duration-700 ease-in-out" data-carousel-item>
                  <img src="{{ Storage::url("yokaitech-images/banner-5.png") }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Banner 1">
              </div>
          </div>
      </div>
      </div>  
      
      <div id="div-kecil" class="col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          @foreach ($bestSales as $product)
            <div id="div-kecil1" class="rounded-lg h-32 md:h-64">
                <figure class="relative w-full h-full transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" style="height: 100%;">
                    <a href="{{ route('dashboard.buyer.products.show', $product->slug) }}">
                        <img class="rounded-lg w-full h-full object-contain" src="{{ Storage::url($product->image) }}" alt="image description">
                    </a>
                    <figcaption class="absolute px-4 text-lg text-black bottom-6">
                      <p class="font-extrabold text-transparent bg-clip-text bg-gradient-to-r to-slate-500 from-slate-950 drop-shadow-lg">
                        {{ $product->name }}
                      </p>
                        <p><mark class="px-2 mt-3 font-semibold text-white bg-slate-600 rounded">
                          ${{ $product->price }}
                        </mark> </p>
                    </figcaption>
                </figure>
            </div>
            @endforeach
        </div>
  </div>

  <div class="mx-auto grid max-w-screen-xl rounded-lg bg-slate-950 md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-3 xl:gap-16 mb-4">
    <div class="lg:col-span-5 lg:mt-0">
      <a href="#">
        <img class="mb-4 h-56 w-56 dark:hidden sm:h-96 sm:w-96 md:h-full md:w-full" src="{{ Storage::url("yokaitech-images/samsung-1.png") }}" alt="peripherals" />
        <img class="mb-4 hidden dark:block md:h-full" src="{{ Storage::url("yokaitech-images/samsung-1.png") }}" alt="peripherals" />
      </a>
    </div>
    <div class="me-auto place-self-center lg:col-span-7">
      <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
        Our Stores provide you the newest products and best prices! Don't miss out <br>
        on the deal!
      </h1>
      <p class="mb-6 text-gray-500 dark:text-gray-400">Buy now and your future self will thank you. Plus, your cat will love the box it comes in! Remember, a happy cat means a happy life!</p>
      <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-3 text-center text-base font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900"> Pre-order now </a>
    </div>
  </div>

  <h3 class="mb-4 text-3xl font-bold flex items-center">
    Best Rating
  </h3>
  <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
    @foreach ($topRatedProducts as $product)
      <x-products.product-card 
        :productname="$product->name" 
        :productImage="$product->image"
        :productPrice="$product->price" 
        :rating="$product->rounded_rating" 
        :count="$product->reviews_count" 
        :user="$user" 
        :product="$product"
        :favorites="$favorites"

                    />
        
    @endforeach
  </div>

  <section >
    <div class="py-4 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-6 ">
        <div class="mx-auto max-w-screen-sm text-center mb-3 lg:mb-6">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 ">Stores</h2>
            <p class="font-light text-gray-500 lg:mb-6 sm:text-xl">Explores the stores and find your favorite products! <a href="{{ route('stores.index') }}" class="hover:underline text-blue-700 hover:text-blue-900">Find more</a></p>
        </div> 
        <div class="grid gap-3 mb-6 lg:mb-16 md:grid-cols-2">
          @php $count = 0; @endphp
          @foreach ($stores as $store)
            @if ($store->hasProduct)
              @if ($count >= 4) @break @endif
                <div class="items-center rounded-lg shadow sm:flex bg-gray-800 border-gray-700">
                    <a href="{{ route('dashboard.buyer.stores.show', $store->slug) }}" class="flex-shrink-0">
                      <img 
                        class="w-40 h-4w-40 rounded-lg object-cover sm:rounded-none sm:rounded-l-lg" 
                        src="{{ Storage::url($store->storeImage) }}" 
                        alt="Bonnie Avatar">
                    </a>
                    <div class="p-5">
                        <h3 class="text-xl font-bold tracking-tight text-white hover:underline">
                            <a href="{{ route('dashboard.buyer.stores.show', $store->slug) }}">{{ $store->name }}</a>
                        </h3>
                        <span class="text-gray-400">by {{ $store->Seller->name }}</span>
                        <p class="mt-3 mb-4 font-light text-gray-400">{{ Str::words($store->description, 6, '...') }}</p>
                    </div>
                </div> 
              @php $count++; @endphp
            @endif
          @endforeach
        </div>  
    </div>
  </section>
  </main>

  @include('components.footer-app')
</x-app-layout>
