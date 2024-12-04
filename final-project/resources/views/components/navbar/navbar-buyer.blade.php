<nav class="bg-slate-900 antialiased sticky top-0 z-20">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
        <div class="flex items-center justify-between">

            <div class="flex items-center space-x-8">
                <div class="shrink-0">
                    <a
                    href="{{ url('/') }}"
                    class="flex items-center justify-between mr-4"
                  >
                    <img
                      src="{{ Storage::url("yokaitech-images/yokaitech-logo.png") }}"
                      class="mr-1 h-8"
                      alt="yokaitech Logo"
                    />
                    <span
                      class="self-center text-xl font-semibold whitespace-nowrap text-white"
                      >YokaiTech</span
                    >
                  </a>    
                </div>

                <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
                    <li>
                        @if (Auth::check())
                            <a href="{{ route('dashboard') }}" title=""
                                class="flex text-sm font-medium text-slate-100 hover:text-slate-400">
                                Home
                            </a>
                        @else
                            <a href="{{ url('/') }}" title=""
                                class="flex text-sm font-medium text-slate-100 hover:text-slate-400">
                                Home
                            </a>
                        @endif

                    </li>
                    <li class="shrink-0">
                        <a href="{{ route('products.index') }}" title=""
                            class="flex text-sm font-medium text-slate-100 hover:text-slate-400">
                            Products
                        </a>
                    </li>
                    <li class="shrink-0">
                        <a href="{{ route('stores.index') }}" title=""
                            class="flex text-sm font-medium text-slate-100 hover:text-slate-400">
                            Store
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex items-center lg:space-x-2">
                @if (Auth::check())
                    @if (Request::is('/') || Auth::user()->role == 'seller' || Auth::user()->role == 'admin')
                        <x-navbar.navbar-button-gotodashboard />    
                    @elseif (Auth::user()->role == 'buyer')
                        <x-navbar.navbar-buttons-buyer />
                    @endif
                @elseif (!Auth::check())
                    <x-navbar.navbar-buttons-guest />
                @endif
            </div>
        </div>
    </div>
</nav>
