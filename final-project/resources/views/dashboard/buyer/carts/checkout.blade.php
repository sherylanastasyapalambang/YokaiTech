<x-app-layout>
    <main class="h-auto">
        <section class=" py-8 antialiased">
            <form action="{{route('dashboard.buyer.orders.store')}}" method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0 ">
                @csrf
              <div class="mx-auto max-w-5xl bg-gray-900 py-10 px-10 rounded-2xl">
                <h2 class="text-xl font-semibold text-white sm:text-2xl">Order summary</h2>
          
                <div class="mt-6 space-y-4 border-b border-t border-gray-700 sm:mt-8">
                  <h4 class="text-lg font-semibold text-white">Billing & Delivery information</h4>
          
                  <dl>
                    <dt class="text-base font-medium text-white">Individual</dt>
                    <dd class="mt-1 text-base font-normal text-gray-400">{{ $user->name }} - {{ $user->phone }}, {{ $user->address }}</dd>
                  </dl>
                  <a href="{{ route('dashboard.buyer.user.edit', $user->id) }}" class=" text-base font-medium hover:underline text-blue-500">Edit</a>
                </div>
          
                <div class="mt-6 sm:mt-8">
                  <div class="relative overflow-x-auto border-b border-gray-800">
                    <table class="w-full text-left font-medium text-white md:table-fixed">
                      <tbody class="divide-y divide-gray-800">
                        @foreach ($cartItems as $cartItem)
                            <tr>
                            <td class="whitespace-nowrap py-4 md:w-[384px]">
                                <div class="flex items-center gap-4">
                                <a href="{{ route('dashboard.buyer.products.show', $cartItem->Product->slug) }}" class="flex items-center aspect-square w-10 h-10 shrink-0">
                                    <img class=" h-auto w-full max-h-full block" src="{{ Storage::url($cartItem->Product->image) }}" alt="imac image" />
                                </a>
                                <a href="{{ route('dashboard.buyer.products.show', $cartItem->Product->slug) }}" class="hover:underline">{{ $cartItem->Product->name }}</a>
                                </div>
                            </td>
            
                            <td class="p-4 text-base font-normal text-white">x{{ $cartItem->quantity }}</td>
            
                            <td class="p-4 text-right text-base font-bold text-white">${{ $cartItem->price }}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
          
                  <div class="mt-4 space-y-6">
                    <h4 class="text-xl font-semibold text-white">Order summary</h4>
          
                    <div class="space-y-4">
                      <div class="space-y-2">
                        <dl class="flex items-center justify-between gap-4">
                          <dt class="text-gray-400">Price</dt>
                          <dd class="text-base font-medium text-white">${{ $originalPrice }}</dd>
                        </dl>
          
                        <dl class="flex items-center justify-between gap-4">
                          <dt class="text-gray-400">Store Pickup</dt>
                          <dd class="text-base font-medium text-white">${{ $storePickup }}</dd>
                        </dl>
          
                        <dl class="flex items-center justify-between gap-4">
                          <dt class="text-gray-400">Tax</dt>
                          <dd class="text-base font-medium text-white">${{ $tax }}</dd>
                        </dl>
                      </div>
          
                      <dl class="flex items-center justify-between gap-4 border-t pt-2 border-gray-700">
                        <dt class="text-lg font-bold text-white">Total</dt>
                        <dd class="text-lg font-bold text-white">${{ $totalPrice }}</dd>
                      </dl>
                    </div>
          
                    <div class="gap-4 sm:flex sm:items-center">
                      <a href="{{ route('dashboard') }}" class="flex justify-center w-full rounded-lg  border px-5  py-2.5 text-sm font-medium focus:z-10 focus:outline-none focus:ring-4 border-gray-600 bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-gray-700">
                        Return to Shopping
                      </a>
                      
                      @if ($user->address)
                      <button 
                      type="submit" 
                      
                      class="mt-4 flex w-full items-center justify-center rounded-lg px-5 py-2.5 text-sm font-medium text-white  focus:outline-none focus:ring-4 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800 sm:mt-0">
                      
                      Send the order
                      </button>
                      @else
                      <button 
                      type="submit" 
                      disabled
                      class="mt-4 flex w-full items-center justify-center rounded-lg px-5 py-2.5 text-sm font-medium text-white  focus:outline-none focus:ring-4 bg-red-600 hover:bg-red-700 focus:ring-red-800 sm:mt-0">
                      
                      input your address
                      </button>
                      @endif
                      
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </section>
    </main>
  </x-app-layout>