<x-app-layout>
    <main class=" h-auto pt-5">
      @if (!$cart || $cartItems->isEmpty())
        <section class="bg-white px-4 py-8 antialiased md:py-16">
          <div class="mx-auto grid max-w-screen-xl rounded-lg bg-gray-50 p-4 dark:bg-gray-800 md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-16 xl:gap-16">
            <div class="lg:col-span-5 lg:mt-0">
              <a href="#">
                <img class="mb-4 hidden dark:block md:h-full" src="{{ Storage::url('/yokaitech-images/no-cart.png') }}" alt="peripherals" />
              </a>
            </div>
            <div class="me-auto place-self-center lg:col-span-7">
              <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
              you have no items in your cart:(
              </h1>
              <p class="mb-6 text-gray-500 dark:text-gray-400">add item in your cart and then you can order!</p>
              <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-3 text-center text-base font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900"> Go Shopping now </a>
            </div>
          </div>
        </section>
      @else
        <section class="bg-white antialiased ">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
              <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Shopping Cart</h2>
          
              <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                  <div class="space-y-3">
                    @foreach ($cartItems as $cartItem)
                    <div class="rounded-lg borderp-4 shadow-sm border-gray-700 bg-gray-800 md:p-6">
                      <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                        <a href="{{ route('dashboard.buyer.products.show', $cartItem->Product->slug) }}" class="shrink-0 md:order-1">
                          <img class="h-24 w-24 block" src="{{ Storage::url($cartItem->Product->image) }}" alt="imac image" />
                        </a>
          
                        <label for="counter-input" class="sr-only">Choose quantity:</label>
                        <div class="flex items-center justify-between md:order-3 md:justify-end">
                          <div class="flex items-center">

                            <button 
                                type="button"
                                class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border focus:outline-none focus:ring-2 border-gray-600 bg-gray-700 hover:bg-gray-600 focus:ring-gray-700"
                                onclick="event.preventDefault(); document.getElementById('decrement-cart-item-{{ $cartItem->id }}').submit();" {{ $cartItem->quantity == 1 ? 'disabled' : '' }}
                            >
                                <svg class="h-2.5 w-2.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <form id="decrement-cart-item-{{ $cartItem->id }}" method="POST" action="{{ route('cartItems.decrement', $cartItem->id) }}" style="display: none;">
                                @csrf
                            </form>

                              <input 
                              type="text" 
                              id="counter-input" 
                              data-input-counter 
                              class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium focus:outline-none focus:ring-0 text-white" 
                              placeholder="" 
                              value="{{ $cartItem->quantity }}" 
                              required 
                              readonly
                          />

                            <button 
                                type="button"
                                class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border focus:outline-none focus:ring-2 border-gray-600 bg-gray-700 hover:bg-gray-600 focus:ring-gray-700"
                                onclick="event.preventDefault(); document.getElementById('increment-cart-item-{{ $cartItem->id }}').submit();" 
                            >
                                <svg class="h-2.5 w-2.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                            <form id="increment-cart-item-{{ $cartItem->id }}" method="POST" action="{{ route('cartItems.increment', $cartItem->id) }}" style="display: none;">
                                @csrf
                            </form>


                          </div>
                          <div class="text-end md:order-4 md:w-32">
                            <p class="text-base font-bold text-white">${{ $cartItem->price }}</p>
                          </div>
                        </div>
          
                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                          <a href="#" class="text-base font-medium hover:underline text-white">{{$cartItem->Product->name}} </a>
                          
                          <div class="flex items-center gap-4">
                            <button 
                                type="button"
                                class="inline-flex items-center text-sm font-medium hover:underline text-red-500"
                                onclick="event.preventDefault(); document.getElementById('remove-cart-item-{{ $cartItem->id }}').submit();"
                            >
                                <svg class="me-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>
                                Remove
                            </button>
                            <form id="remove-cart-item-{{ $cartItem->id }}" method="POST" action="{{ route('cartItems.remove', $cartItem->id) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
                <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                  <div class="space-y-4 rounded-lg border p-4 shadow-sm border-gray-700 bg-gray-800 sm:p-6">
                    <p class="text-xl font-semibold text-white">Order summary</p>
          
                    <div class="space-y-4">
                      <div class="space-y-2">
                        <dl class="flex items-center justify-between gap-4">
                          <dt class="text-base font-normal text-gray-400">Original price</dt>
                          <dd class="text-base font-medium text-white">${{ $originalPrice }}</dd>
                        </dl>
          
                        <dl class="flex items-center justify-between gap-4">
                          <dt class="text-base font-normal text-gray-400">Store Pickup</dt>
                          <dd class="text-base font-medium text-white">${{ $storePickup }}</dd>
                        </dl>
          
                        <dl class="flex items-center justify-between gap-4">
                          <dt class="text-base font-normal text-gray-400">Tax (10%)</dt>
                          <dd class="text-base font-medium text-white">${{ $tax }}</dd>
                        </dl>
                      </div>
          
                      <dl class="flex items-center justify-between gap-4 border-t pt-2 border-gray-700">
                        <dt class="text-base font-bold text-white">Total</dt>
                        <dd class="text-base font-bold text-white">${{ $totalPrice }}</dd>
                      </dl>
                    </div>
          
                    <a href="{{ route('dashboard.buyer.cartItems.index') }}" class="flex w-full items-center justify-center rounded-lg px-5 py-2.5 text-sm font-medium focus:outline-none focus:ring-4 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                      Proceed to Checkout
                    </a>
                    <div class="flex items-center justify-center gap-2">
                      <span class="text-sm font-normal text-gray-400"> or </span>
                      <a href="{{ route('products.index')}}" title="" class="inline-flex items-center gap-2 text-sm font-medium underline hover:no-underline text-blue-500">
                        Continue Shopping
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
      @endif

    </main>
</x-app-layout>
  