<x-app-layout>
    <main class=" md:ml-64 h-auto pt-10">
        <section class="bg-white py-8 antialiased">
            <div class="mx-auto grid max-w-screen-xl px-4 pb-8 md:grid-cols-12 lg:gap-12 lg:pb-16 xl:gap-0">
              <div class="content-center justify-self-start md:col-span-7 md:text-start">
                @if (!$user->store)
                <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight md:max-w-2xl md:text-5xl xl:text-6xl">Opps! you don't have store yet<br />Up to 50% OFF!</h1>
                <p class="mb-4 max-w-2xl text-gray-500 dark:text-gray-400 md:mb-12 md:text-lg lg:mb-5 lg:text-xl">Don't Wait any longer! Create Store now!</p>
                <a href="{{ route('dashboard.seller.stores.create') }}" class="inline-block rounded-lg bg-blue-700 px-6 py-3.5 text-center font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Create Store Now
                </a>
                @else
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight md:max-w-2xl md:text-5xl xl:text-6xl">Welcome!<br />{{ $user->name}}</h1>
                @endif
              </div>
              <div class="hidden md:col-span-5 md:mt-0 md:flex">
                <img class="block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/girl-shopping-list-dark.svg" alt="shopping illustration" />
              </div>
            </div>

            <div class=" flex justify-around border-b border-t border-gray-200 py-4 md:py-8 ">
              <div>
                <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z"/>
                </svg>
                <h3 class="mb-2 text-gray-500 dark:text-gray-400">Orders</h3>
                <span class="flex items-center text-2xl font-bold text-gray-900 "
                  >{{$ordersCount}}
                </span>
              </div>

              <div>
                <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                </svg>
                <h3 class="mb-2 text-gray-500 dark:text-gray-400">Ordered Items</h3>
                <span class="flex items-center text-2xl font-bold text-gray-900 "
                  >{{ $orderedItemsCount }}
                </span>
              </div>

              <div>
                <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
                </svg>
                <h3 class="mb-2 text-gray-500 dark:text-gray-400">Reviews</h3>
                <span class="flex items-center text-2xl font-bold text-gray-900 "
                  >{{ $reviewsCount }}
                </span>
              </div>

              <div>
                <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                </svg>
                <h3 class="mb-2 text-gray-500 dark:text-gray-400">favorites</h3>
                <span class="flex items-center text-2xl font-bold text-gray-900 "
                  >{{ $favoritesCount }}
                </span>
              </div>
            </div>
          </section>
    </main>
</x-app-layout>
