<x-app-layout>
    <main class="h-auto @if ($user->role !== 'buyer')  md:ml-64 pt-10 @endif">
        <section class="bg-white py-8 antialiased md:py-8">
            <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
              <h2 class="mb-4 text-xl font-semibold text-gray-900 sm:text-2xl md:mb-6">Profile Detail</h2>
              @if ($user->role === 'buyer')
                <div class=" flex justify-around border-b border-t border-gray-200 py-4 dark:border-gray-700 md:py-8 ">
                  <div>
                    <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                    </svg>
                    <h3 class="mb-2 text-gray-500 dark:text-gray-400">Orders made</h3>
                    <span class="flex items-center text-2xl font-bold text-gray-900 "
                      >{{ $ordersCount }}
                    </span>
                  </div>

                  <div>
                    <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
                    </svg>
                    <h3 class="mb-2 text-gray-500 dark:text-gray-400">Reviews added</h3>
                    <span class="flex items-center text-2xl font-bold text-gray-900 "
                      >{{ $reviewsCount }}
                    </span>
                  </div>

                  <div>
                    <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                    </svg>
                    <h3 class="mb-2 text-gray-500 dark:text-gray-400">Favorite products added</h3>
                    <span class="flex items-center text-2xl font-bold text-gray-900 "
                      >{{  $favoritesCount }}
                    </span>
                  </div>
                </div>
              @endif

              <div class="py-4 md:py-8">
                <div class="mb-4 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                  <div class="space-y-4">
                    <div class="flex space-x-4">
                      <img class="h-32 w-32 rounded-lg" src="{{ Storage::url($user->profileImage) }}" alt="profile image" />
                      <div class="flex items-center">
                        <h2 class="flex items-center text-xl font-bold leading-none text-gray-900  sm:text-2xl">{{ $user->name }}</h2>
                      </div>
                    </div>
                    <dl class="">
                      <dt class="font-semibold text-gray-900 ">Email Address</dt>
                      <dd class="text-gray-500 dark:text-gray-400">{{ $user->email }}</dd>
                    </dl>
                    <dl>
                      <dt class="font-semibold text-gray-900 ">Home Address</dt>
                      <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                        <svg class="hidden h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                        </svg>
                        {{ $user->address }}
                      </dd>
                    </dl>
                    <dl>
                      <dt class="font-semibold text-gray-900 ">Phonenumber</dt>
                      <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                        <svg class="hidden h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"/>
                        </svg>                              
                        {{ $user->phone }}
                      </dd>
                    </dl>
                  </div>
                </div>
                @if ($user->role === 'buyer')
                  <a href="{{ route('dashboard.buyer.user.edit', $user->id) }}" 
                    class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">
                    <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"></path>
                    </svg>
                    Edit your data
                  </a>
                @elseif ($user->role === 'seller')
                  <a href="{{ route('dashboard.seller.user.edit', $user->id) }}" 
                    class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">
                    <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"></path>
                    </svg>
                    Edit your data
                  </a>
                @endif
              </div>
            </div>
        </section>
    </main>
</x-app-layout>