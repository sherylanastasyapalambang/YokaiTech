<x-app-layout>
    <main class="p-4 md:ml-64 h-auto pt-20">
        <div class="relative overflow-x-auto sm:rounded-lg p-3 bg-slate-800 shadow-sm shadow-slate-500">
            <div class="flex flex-wrap items-center justify-between gap-4 pb-4">
                <!-- Left Section -->
                {{-- <div class="flex items-center gap-4">
                    <a href=" {{ route('dashboard.admin.users.create') }} "
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Add user
                    </a>
                </div> --}}

                <div class="flex items-center gap-2">
                    <form action="{{ route('dashboard.admin.users.index') }}" method="GET" class="flex items-center gap-2 relative">
                        @csrf
                        <!-- Wrapper untuk ikon -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                
                        <!-- Input Search -->
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Enter name or email"
                            class="block w-full sm:w-80 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    
                        <!-- Select Filter -->
                        <select name="role" onchange="this.form.submit()" 
                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            <option value="">All</option>
                            <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                            <option value="buyer" {{ request('role') == 'buyer' ? 'selected' : '' }}>Buyer</option>
                        </select>
                    </form>
                </div>                                               
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @if ($user->role != 'admin')
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                <th scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="w-10 h-10 rounded-full" src="{{ Storage::url($user->profileImage) }}"
                                        alt="profile image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user->role }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->phone }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->address }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('dashboard.admin.users.edit', $user->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <button 
                                        data-modal-target="delete-user-{{ $user->id }}" 
                                        data-modal-toggle="delete-user-{{ $user->id }}"
                                        class="ml-3 font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                </td>
                                <x-modals.delete-modal 
                                    :id="'delete-user-'.$user->id" 
                                    :entity="'user'" 
                                    :action="route('dashboard.admin.users.destroy', $user->id)" 
                                />
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </main>
</x-app-layout>
