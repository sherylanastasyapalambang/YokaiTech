@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
  <main class="md:ml-64 h-auto pt-20">
    <section class="bg-gray-50">
      <div class="mx-auto max-w-screen-xl px-4">
          <!-- Start coding here -->
          <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form method="GET" action="{{ route('dashboard.admin.stores.index') }}" class="flex items-center">
                        @csrf
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="simple-search" 
                                name="search" 
                                value="{{ request('search') }}" 
                                class="bg-gray-700 border border-gray-600 text-gray-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2" 
                                placeholder="Search by store or seller name">
                        </div>
                    </form>
                </div>                
                  {{-- <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                      <a href="{{ route('dashboard.admin.stores.create') }}"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                          <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                          </svg>
                          Add Stores
                        </a>
                  </div> --}}
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                          <tr>
                              <th scope="col" class="px-4 py-3">Store name</th>
                              <th scope="col" class="px-4 py-3">Seller</th>
                              <th scope="col" class="px-4 py-3">phone</th>
                              <th scope="col" class="px-4 py-3">Address</th>
                              <th scope="col" class="px-4 py-3">description</th>
                              <th scope="col" class="px-4 py-3">
                                  <span class="sr-only">Actions</span>
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                            @foreach ($stores as $store)
                                <tr class="border-b dark:border-gray-700">
                                    <!-- <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">Apple iMac 27&#34;</th> -->
                                    <th scope="row" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <img src="{{ Storage::url($store->storeImage) }}" alt="Store Image" class="w-auto h-8 mr-3">
                                        @if ($store->hasProduct)
                                            <a href="{{ route('dashboard.admin.stores.show', $store->slug) }}" class="hover:underline">{{ $store->name }}</a>
                                        @else
                                            {{ $store->name }}
                                        @endif
                                    </th>
                                    <td class="px-4 py-3">{{ $store->seller->name }}</td>
                                    <td class="px-4 py-3">{{ $store->phone }}</td>
                                    <td class="px-4 py-3">{{ $store->address }}</td>
                                    <td class="px-4 py-3"><a href="#" data-popover-target="store-detail-description-{{ $store->id }}" class="underline">{{ Str::words($store->description, 5, '...') }}</a></td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="store-dropdown-button-{{ $store->id }}" data-dropdown-toggle="store-dropdown-{{ $store->id }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="store-dropdown-{{ $store->id }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="store-dropdown-button-{{ $store->id }}">
                                                <li>
                                                    <a href="{{ route('dashboard.admin.stores.show', $store->slug) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                                </li>
                                                {{-- <li>
                                                    <a href="{{ route('dashboard.admin.stores.edit', $store->slug) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li> --}}
                                            </ul>
                                            {{-- <div class="py-1">
                                                <button  
                                                    data-modal-target="delete-store-{{ $store->id }}" 
                                                    data-modal-toggle="delete-store-{{ $store->id }}"
                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                            </div> --}}
                                        </div>
                                    </td>
                                </tr>
                                <x-popover.detail-popover 
                                    :id="'store-detail-description-'.$store->id"
                                    :title="'Detail Description'"
                                    :content="$store->description"/>

                                {{-- <x-modals.delete-modal 
                                    :id="'delete-store-'.$store->id" 
                                    :entity="'store'" 
                                    :action="route('dashboard.admin.stores.destroy', $store->id)" /> --}}
                            @endforeach
                      </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $stores->links() }}
                    </div>
              </div>
          </div>
      </div>
      </section>
  </main>
</x-app-layout>
