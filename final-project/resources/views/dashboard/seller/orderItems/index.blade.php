<x-app-layout>
    <main class="p-1 md:ml-64 h-auto pt-20">
        <section class="bg-gray-50 py-3 sm:py-5">
            <div class="px-4 mx-auto max-w-screen-2xl">
                <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                    <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="w-full md:w-2/3">
                            <form method="GET" class="flex flex-col lg:flex-row lg:items-center space-y-3 lg:space-y-0 lg:space-x-4">
                                @csrf
                                <div class="relative w-full lg:w-56">
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
                    
                                <div class="w-full lg:w-32">
                                    <label for="status-filter" class="sr-only">Status</label>
                                    <select id="status-filter" name="status-filter" onchange="this.form.submit()"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">All Status</option>
                                        <option value="On progress" {{ request('status-filter') == 'On progress' ? 'selected' : '' }}>On progress</option>
                                        <option value="shipped" {{ request('status-filter') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ request('status-filter') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="pending" {{ request('status-filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="cancelled" {{ request('status-filter') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    
                        
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="pl-10 px-4 py-3">Order ID</th>
                                    <th scope="col" class="px-4 py-3">Product Name</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3">Quantity</th>
                                    <th scope="col" class="px-4 py-3">Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($orderItems as $order)
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class=" px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                       <a href="{{ route('dashboard.seller.orders.show', $order->Order->id) }}" class="hover:underline">#ORD123{{ $order->Order->id }}</a> 
                                    </td>

                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $order->product->name }}
                                    </td>
                                    
                                    <td class="pl-10 px-4 py-2">
                                        <span class=" text-xs font-medium px-2 py-0.5 rounded 
                                          @if ($order->Order->status == 'On progress') 
                                            bg-yellow-900 text-yellow-300
                                          @elseif ($order->Order->status == 'shipped')
                                            bg-green-900 text-green-300
                                          @elseif ($order->Order->status == 'delivered')
                                            bg-blue-900 text-blue-300
                                          @elseif ($order->Order->status == 'pending')
                                            bg-gray-600 text-gray-300
                                          @elseif ($order->Order->status == 'cancelled')
                                            bg-red-900 text-red-300
                                          @endif">
                                          {{ $order->Order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ $order->quantity }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ $order->updated_at }}
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $orderItems->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
