<x-app-layout>
    <main 
    class="h-auto
      @if ($user->role == 'seller')
        md:ml-64 
        pt-10
      @endif ">
        <section class="bg-white py-8 antialiased">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 ">
              <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Track the delivery of order #ORD123{{ $order->id }}</h2>
          
              <div class="mt-6 sm:mt-8 lg:flex lg:gap-8 ">
                <div class=" bg-gray-900 w-full divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-200 dark:divide-gray-700 dark:border-gray-700 lg:max-w-xl xl:max-w-2xl">
                    @foreach ($order->OrderItems as $orderItem)
                        <div class="space-y-4 p-6">
                        <div class="flex items-center gap-6">
                            
                        <a href="{{ route('dashboard.buyer.products.show', $orderItem->Product->slug) }}" class="h-14 w-14 shrink-0">
                            <img class="h-full w-full block" src="{{ Storage::url($orderItem->Product->image) }}" alt="Product image" />
                        </a>
            
                        <a href="#" class="min-w-0 flex-1 font-medium text-gray-900 hover:underline dark:text-white">{{ $orderItem->Product->name }}</a>
                        </div>
            
                        <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-normal text-gray-500 dark:text-gray-400"><span class="font-medium text-gray-900 dark:text-white">Product ID:</span>#PR098{{ $orderItem->Product->id }}</p>
            
                        <div class="flex items-center justify-end gap-4">
                            <p class="text-base font-normal text-gray-900 dark:text-white">x{{ $orderItem->quantity }}</p>
            
                            <p class="text-xl font-bold leading-tight text-gray-900 dark:text-white">${{ $orderItem->price }}</p>
                        </div>
                        </div>
                    </div>
                    @endforeach
          
                  <div class="space-y-4 bg-gray-50 p-6 dark:bg-gray-800">
                    <div class="space-y-2">
                      <dl class="flex items-center justify-between gap-4">
                        <dt class="font-normal text-gray-500 dark:text-gray-400">Price</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">${{ $originalPrice }}</dd>
                      </dl>
          
                      <dl class="flex items-center justify-between gap-4">
                        <dt class="font-normal text-gray-500 dark:text-gray-400">Store Pickup</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">${{ $storePickup }}</dd>
                      </dl>
          
                      <dl class="flex items-center justify-between gap-4">
                        <dt class="font-normal text-gray-500 dark:text-gray-400">Tax</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">${{ $tax }}</dd>
                      </dl>
                    </div>
          
                    <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                      <dt class="text-lg font-bold text-gray-900 dark:text-white">Total</dt>
                      <dd class="text-lg font-bold text-gray-900 dark:text-white">${{ $order->total_price }}</dd>
                    </dl>
                  </div>
                </div>
          
                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                  <div class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Order history</h3>
                    <ol class="relative ms-3 border-s border-gray-200 dark:border-gray-700">

                      @if ($order->status !== 'delivered')
                        <li class="mb-10 ms-6">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full  dark:bg-gray-700 dark:ring-gray-800">
                            <svg class="h-4 w-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                            </svg>
                          </span>
                          <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">-</h4>
                          <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Products is not delivered yet</p>
                        </li>
                      @else
                        <li class="mb-10 ms-6 text-blue-500">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full dark:bg-blue-900 dark:ring-gray-800">
                            <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                          </span>
                          <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-blue-500">
                            {{ $deliveredStatus ? $deliveredStatus->updated_at->format('d-m-Y H:i:s') : '-' }}
                          </h4>
                          <p class="text-sm font-normal">Products is delivered</p>
                        </li>
                      @endif
                      
                      @if ($order->status == 'shipped' || $order->status == 'delivered')
                        <li class="mb-10 ms-6 text-blue-500">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full dark:bg-blue-900 dark:ring-gray-800">
                            <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                          </span>
                          <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-blue-500">
                            {{ $shippedStatus ? $shippedStatus->updated_at->format('d-m-Y H:i:s') : '-' }}
                          </h4>
                          <p class="text-sm font-normal">Products being delivered</p>
                        </li>
                      @else
                        <li class="mb-10 ms-6">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-800">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                            </svg>
                          </span>
                          <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">-</h4>
                          <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Products is not being delivered yet</p>
                        </li>
                      @endif

                      @if ($order->status == 'pending')
                        <li class="mb-10 ms-6">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-800">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                          </span>
                          <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">
                            {{ $pendingStatus ? $pendingStatus->updated_at->format('d-m-Y H:i:s') : '-' }}
                          </h4>
                          <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Your order is currently pending and will be processed soon.</p>
                        </li>
                      @elseif ($order->status == 'cancelled')
                        <li class="mb-10 ms-6">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white dark:bg-red-700 dark:ring-gray-800">
                            <svg class="h-4 w-4 text-gray-500 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                          </span>
                          <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">
                            {{ $cancelledStatus ? $cancelledStatus->updated_at->format('d-m-Y H:i:s') : '-' }}
                          </h4>
                          <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Your order has been cancelled.</p>
                        </li>
                      @else
                        <li class="mb-10 ms-6 text-blue-700 dark:text-blue-500">
                          <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                            <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                          </span>
                          <h4 class="mb-0.5 font-semibold">
                            {{ $onProgressStatus ? $onProgressStatus->updated_at->format('d-m-Y H:i:s') : '-' }}
                          </h4>
                          <p class="text-sm">Products in the courier's warehouse</p>
                        </li>
                      @endif
                    </ol>
                    @if ($user->role == 'buyer')
                      <div class="gap-4 sm:flex sm:items-center">
                        @if ($order->status == 'cancelled' || $order->status == 'delivered' || $order->status == 'shipped') 
                          <a 
                            href="{{ route('dashboard') }}" 
                            class="text-center w-full rounded-lg  border px-5  py-2.5 text-sm font-medium focus:z-10 focus:outline-none focus:ring-4 border-gray-600 bg-gray-800 text-gray-400 hover:text-white 
                            @if ($order->status == 'cancelled' || $order->status == 'delivered'|| $order->status == 'shipped') 
                              hover:bg-blue-500 focus:ring-blue-400
                            @else
                              hover:bg-red-500 focus:ring-red-400
                            @endif">
                            Go Shopping
                          </a>
                        @else
                          <button 
                            type="button" 
                            data-modal-target="cancel-order-{{ $order->id }}" 
                            data-modal-toggle="cancel-order-{{ $order->id }}"
                            class="w-full rounded-lg  border border-gray-200 bg-white px-5  py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-red-500 dark:hover:text-white dark:focus:ring-red-400">
                            Cancel the order
                          </button>
                          <x-modals.cancel-order 
                            :id="'cancel-order-'.$order->id" 
                            :order="$order"
                            />
                        @endif
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </section>
    </main>
</x-app-layout>