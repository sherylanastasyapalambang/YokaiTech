@php
    $role = auth()->user()->role;
    $user = auth()->user();
@endphp

<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full md:translate-x-0 bg-slate-800 border-slate-700"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-slate-800">
        <form action="#" method="GET" class="md:hidden mb-2">
            <label for="sidebar-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                        </path>
                    </svg>
                </div>
                <input type="text" name="search" id="sidebar-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Search" />
            </div>
        </form>
        @if ($role == 'admin')
            <x-sidebar.sidebar-buttons-admin />
        @elseif($role === 'seller' && $user->store)
            <x-sidebar.sidebar-buttons-seller />
        @endif
        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
            <li>
                @if ($user->role === 'seller')
                    <a href="{{ route('dashboard.seller.user.show', $user->id) }}"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg duration-75 hover:bg-gradient-to-r hover:from-slate-800 hover:to-slate-600 transition-all dark:text-white group">
                        <img src="{{ asset('storage/' . $user->profileImage) }}" alt="Profile Image"
                            class="w-6 h-6 rounded-full">
                        <span class="ml-3">{{ $user->name }}</span>
                    </a>
                @elseif ($user->role === 'admin')
                    <a href="{{ route('dashboard.buyer.user.show', $user->id) }}"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg duration-75 hover:bg-gradient-to-r hover:from-slate-800 hover:to-slate-600 transition-all dark:text-white group">
                        <img src="{{ asset('storage/' . $user->profileImage) }}" alt="Profile Image"
                            class="w-6 h-6 rounded-full">
                        <span class="ml-3">{{ $user->name }}</span>
                    </a>
                @endif
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg duration-75 hover:bg-gradient-to-r hover:from-slate-800 hover:to-slate-600 transition-all dark:text-white group"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg aria-hidden="true"
                            class="w-6 h-6 text-gray-400 group-hover:text-white"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="ml-3">Logout</span>
                    </a>
                </form>

            </li>
        </ul>

    </div>
</aside>
