<nav
class="bg-slate-800 border-b border-slate-800 px-4 py-2.5 fixed left-0 right-0 top-0 z-50"
>
<div class="flex flex-wrap justify-between items-center">
  <div class="flex justify-start items-center">
    <button
      data-drawer-target="drawer-navigation"
      data-drawer-toggle="drawer-navigation"
      aria-controls="drawer-navigation"
      class="p-2 mr-2  rounded-lg cursor-pointer md:hidden focus:bg-slate-700 focus:ring-2 focus:ring-slate-700 text-slate-400 hover:bg-slate-700 hover:text-white"
    >
      <svg
        aria-hidden="true"
        class="w-6 h-6"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
          clip-rule="evenodd"
        ></path>
      </svg>
      <svg
        aria-hidden="true"
        class="hidden w-6 h-6"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd"
        ></path>
      </svg>
      <span class="sr-only">Toggle sidebar</span>
    </button>
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
        class="self-center text-2xl font-semibold whitespace-nowrap text-white"
        >YokaiTech</span
      >
    </a>    
  </div>
  <div class="flex items-center lg:order-2">
    <button
      type="button"
      data-drawer-toggle="drawer-navigation"
      aria-controls="drawer-navigation"
      class="p-2 mr-1 rounded-lg md:hidden text-slate-400 hover:text-white hover:bg-slate-700 focus:ring-4 focus:ring-slate-600"
    >
      <span class="sr-only">Toggle search</span>
      <svg
        aria-hidden="true"
        class="w-6 h-6"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          clip-rule="evenodd"
          fill-rule="evenodd"
          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
        ></path>
      </svg>
    </button>
  </div>
</div>
</nav>