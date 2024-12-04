<x-app-layout>
    <main class="md:ml-64 h-auto pt-12">
        <section class=" bg-white dark:bg-gray-900 bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] dark:bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern-dark.svg')]">
            <div class="p-28 py-8 px-10 mx-auto max-w-screen-xl flex flex-col lg:flex-row items-center lg:justify-between text-center lg:text-left">
                <!-- Image -->
                <div class="mb-6 lg:mb-0 lg:mr-8">
                    <img class="max-h-64 max-w-96 mx-auto lg:mx-0 rounded-2xl" src="{{ Storage::url($store->storeImage) }}" alt="image description">
                </div>
                <!-- Text -->
                <div>
                    <h3 class="mb-4 text-4xl font-bold tracking-tight leading-none text-gray-900  dark:text-white">
                        {{ $store->name }}
                    </h3>
                    <p class="mb-4 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-200">
                        {{ $store->description }}
                    </p>
                        <a href="{{ route('dashboard.seller.stores.edit', $store->slug) }}"
                        class="mb-8 inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-medium focus:outline-none focus:ring-4 bg-slate-100 hover:bg-slate-200 focus:ring-slate-300">
                            <svg class="mr-3 w-5 h-5 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                              </svg>
                            edit store
                        </a>
                </div>
            </div>
        </section>

        <div class="mt-5 m-5 rounded-lg border border-slate-200 bg-slate-50 p-4 md:p-8">
          <div class="mb-2 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
          <div class="space-y-4">
            <dl class="mb-1">
                <dt class="font-semibold text-slate-900">Store Address</dt>
                <dd class=" flex items-center gap-1 text-slate-500">
                    <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd"/>
                      </svg>                      
                    {{ $store->address }}
                </dd>
              </dl>
            </div>
            <div class="space-y-4">
                <dl class="mb-3">
                    <dt class="font-semibold text-slate-900">Store's phonenumber</dt>
                    <dd class="flex items-center gap-1 text-slate-500">
                    <svg class="hidden h-5 w-5 shrink-0 text-slate-400 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"/>
                    </svg>                              
                    {{ $store->phone }}
                    </dd>
                </dl>
            </div>
            </div>
            <hr>
            <h3 class="mt-2 mb-4 text-xl font-semibold text-slate-900">Seller Profile</h3>
            <div class="mb-2 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                <div class="space-y-4">
                    <div class="flex space-x-4">
                        <img class="h-16 w-16 rounded-lg" src="{{ Storage::url($user->profileImage) }}" alt="Helene avatar" />
                        <div class="flex items-center" >
                        <h2 class="flex items-center text-xl font-bold leading-none text-gray-900 sm:text-2xl">{{ $user->name }}</h2>
                        </div>
                    </div>
                    <dl class="">
                        <dt class="font-semibold text-gray-900">Email Address</dt>
                        <dd class="text-gray-500 dark:text-gray-400">{{ $user->email }}</dd>
                      </dl>
                </div>

                <div class=" space-y-6">
                        <dl>
                          <dt class="font-semibold text-gray-900">Phone Number</dt>
                          <dd class="text-gray-500 dark:text-gray-400">
                            <svg class="hidden h-5 w-5 shrink-0 text-slate-400 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"/>
                            </svg> 
                            {{ $user->phone }}
                          </dd>
                        </dl>
                        <dl>
                          <dt class="font-semibold text-gray-900">Address</dt>
                          <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                            <svg class="hidden h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                            </svg>
                            {{ $user->address }}
                          </dd>
                        </dl>
                </div>  
            </div>
                
        </div>
        <div class="p-4 mt-5">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h1 class="text-xl font-semibold ml-3 w-full sm:w-auto">All Product</h1>
                
            </div>
            
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <p>{{$product->name}}</p>
                    {{-- <x-products.product-card 
                        :productname="$product->name" 
                        :productImage="$product->image"
                        :productPrice="$product->price" 
                        :rating="$product->rounded_rating" 
                        :count="$product->reviews_count" 
                        :user="$user" 
                        :product="$product"
                    /> --}}
                @endforeach
            </div>
        </div>
      </main>
</x-app-layout>

