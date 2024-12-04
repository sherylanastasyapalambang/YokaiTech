@php
    $user = auth()->user();
@endphp

<button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button"
    class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
    <img class="w-6 h-6 rounded-full mr-2" src="{{ Storage::url($user->profileImage) }}" alt="profile image">
   {{ $user->name}}
    <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
    </svg>
</button>

<div id="userDropdown1"
    class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
    <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
        <li><a href="{{ route('dashboard.buyer.user.show', $user->id) }}" title=""
                class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                My Account </a></li>
        <li><a href="{{ route('dashboard.buyer.orders.index') }}" title=""
                class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                My Orders </a></li>
        <li>
            @if($user->Cart)
            <a href="{{ route('dashboard.buyer.carts.index') }}" title=""
                class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                My Cart 
            </a>
            @else
            <p class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm text-red-500 hover:text-gray-600 dark:hover:bg-red-600">
                Cannot open cart yet! <br>
                please add your first item!
            </p>
            @endif
        </li>
        <li><a href="{{ route('dashboard.buyer.favorites.index') }}" title=""
                class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                Favourites </a></li>
    </ul>

    <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="#" title="Logout" onclick="event.preventDefault(); this.closest('form').submit();"
                class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                Logout
            </a>
        </form>
    </div>
</div>
</div>
