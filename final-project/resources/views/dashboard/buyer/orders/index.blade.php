<x-app-layout>
    <main class="h-auto">
        <section class="py-8 antialiased">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
              <div class="mx-auto max-w-5xl">
                <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                  <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">My orders</h2>
          
                  <form method="GET">
                    @csrf
                    <div class="mt-6 gap-4 space-y-4 sm:mt-0 sm:flex sm:items-center sm:justify-end sm:space-y-0">
                        <div>
                        <label for="status-filter" class="sr-only mb-2 block text-sm font-medium text-gray-900 dark:text-white">Select order type</label>
                        <select id="status-filter" name="status-filter" onchange="this.form.submit()" 
                            class="block w-full min-w-[8rem] rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="">All orders</option>
                            <option value="On progress" {{ request('status-filter') == 'On progress' ? 'selected' : '' }}>On progress</option>
                            <option value="shipped" {{ request('status-filter') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status-filter') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="pending" {{ request('status-filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="cancelled" {{ request('status-filter') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        </div>
            
                        <span class="inline-block text-gray-500 "> from </span>
                        
                        <div>
                            <label for="duration" class="sr-only mb-2 block text-sm font-medium text-gray-900 dark:text-white">Select duration</label>
                            <select id="duration" name="duration" onchange="this.form.submit()" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                <option value="this week" {{ request('duration') == 'this week' ? 'selected' : '' }}>This week</option>
                                <option value="this month" {{ request('duration') == 'this month' ? 'selected' : '' }}>This month</option>
                                <option value="last 3 months" {{ request('duration') == 'last 3 months' ? 'selected' : '' }}>Last 3 months</option>
                                <option value="last 6 months" {{ request('duration') == 'last 6 months' ? 'selected' : '' }}>Last 6 months</option>
                                <option value="this year" {{ request('duration') == 'this year' ? 'selected' : '' }}>This year</option>
                            </select>
                        </div>
                    </div>
                </form>
                </div>
          
                <div class="mt-6 flow-root sm:mt-8 bg-gray-900 rounded-2xl">
                  <div class="divide-y divide-gray-200 dark:divide-gray-700 ">
                    @forelse ($orders as $order)
                        <div class="flex flex-wrap items-center gap-y-4 py-6 px-6">
                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Order ID:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            #ORD123{{ $order->id }}
                            </dd>
                        </dl>
            
                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Date:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $order->created_at }}</dd>
                        </dl>
            
                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Price:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">${{ $order->total_price }}</dd>
                        </dl>
            
                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Status:</dt>
                            @if ($order->status == 'On progress')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded px-2.5 py-0.5 text-xs font-medium bg-yellow-900 text-yellow-300">
                                <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z" />
                                </svg>
                                    On progress
                                </dd>
                            @elseif ($order->status == 'shipped')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded px-2.5 py-0.5 text-xs font-medium bg-blue-900 text-blue-300">
                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                        Shipped
                                </dd>
                            @elseif ($order->status == 'delivered')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded px-2.5 py-0.5 text-xs font-medium bg-green-900 text-green-300">
                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                    </svg>
                                        Delivered
                                </dd>
                            @elseif ($order->status == 'pending')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded px-2.5 py-0.5 text-xs font-medium bg-gray-600 text-gray-300">
                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                        Pending
                                </dd>
                            @elseif ($order->status == 'cancelled')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded px-2.5 py-0.5 text-xs font-medium bg-red-900 text-red-300">
                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z" />
                                    </svg>
                                        Cancelled
                                </dd>
                            @endif
                        </dl>
                        
                        <div class="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                            @if ($order->status == 'On progress')
                                <button 
                                    type="button" 
                                    data-modal-target="cancel-order-{{ $order->id }}" 
                                    data-modal-toggle="cancel-order-{{ $order->id }}"
                                    class="w-full rounded-lg border border-red-700 px-3 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white dark:focus:ring-red-900 lg:w-auto">
                                    Cancel order
                                </button>

                                <x-modals.cancel-order 
                                    :id="'cancel-order-'.$order->id" 
                                    :order="$order"/>
                            @endif
                            <a href="{{ route('dashboard.buyer.orders.show', $order->id) }}" class="w-full inline-flex justify-center rounded-lg  border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 lg:w-auto">
                                View details
                            </a>
                        </div>
                        </div>
                    @empty
                        <section class="bg-white px-4 py-8 antialiased md:py-16">
                            <div class="mx-auto grid max-w-screen-xl rounded-lg bg-gray-50 p-4 dark:bg-gray-800 md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-16 xl:gap-16">
                            <div class="lg:col-span-5 lg:mt-0">
                                <a href="#">
                                <img class="mb-4 hidden dark:block md:h-full" src="{{ Storage::url('/yokaitech-images/no-order.png') }}" alt="peripherals" />
                                </a>
                            </div>
                            <div class="me-auto place-self-center lg:col-span-7">
                                <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
                                    you have no order history yet:(
                                </h1>
                                <p class="mb-6 text-gray-500 dark:text-gray-400">order your very first items now!</p>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-3 text-center text-base font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900"> Go Shopping now </a>
                            </div>
                            </div>
                        </section>
                    @endforelse
                  </div>
                </div>
          
                <nav class="mt-6 flex items-center justify-center sm:mt-8" aria-label="Page navigation example">
                    <div class="p-4">
                        {{ $orders->links() }}
                    </div>
                </nav>
              </div>
            </div>
          </section>
    </main>
</x-app-layout>