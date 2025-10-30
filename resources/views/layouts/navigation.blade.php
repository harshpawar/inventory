<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <!-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div> -->

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('inventory-items.index')" :active="request()->routeIs('inventory-items.*')">
                        {{ __('Inventory') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('manufactures.index')" :active="request()->routeIs('manufactures.*')">
                        {{ __('Manufacturing') }}
                    </x-nav-link>
                    {{-- Start: Reports Dropdown (Desktop) --}}
                    {{-- <div class="relative" x-data="{ openReports: false }"> --}}
                        <a type="button"
                            @click="openReports = !openReports"
                            @keydown.escape.window="openReports = false"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition {{ request()->routeIs('reports.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}"
                            :class="{'text-indigo-600 dark:text-indigo-400': openReports}"
                            aria-haspopup="true"
                            aria-expanded="openReports">
                            {{ __('Reports') }}
                            <svg class="ms-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <div
                            x-show="openReports"
                            @click.away="openReports = false"
                            @keydown.escape.window="openReports = false"
                            class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-40"
                            style="min-width: 180px;"
                            x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                            <div class="py-1">
                                <x-dropdown-link :href="route('reports.manufactured', ['from' => now()->toDateString(), 'to' => now()->toDateString()])"
                                    :active="request()->routeIs('reports.manufactured')"
                                    @click="openReports = false">
                                    {{ __('Manufactured Products') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reports.inventoryUsage', ['from' => now()->toDateString(), 'to' => now()->toDateString()])"
                                    :active="request()->routeIs('reports.inventoryUsage')"
                                    @click="openReports = false">
                                    {{ __('Inventory Usage') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reports.inventoryMovements', ['from' => now()->toDateString(), 'to' => now()->toDateString()])"
                                    :active="request()->routeIs('reports.inventoryMovements')"
                                    @click="openReports = false">
                                    {{ __('Inventory Movements') }}
                                </x-dropdown-link>
                            </div>
                        </div>
                    {{-- </div> --}}
                    {{-- End: Reports Dropdown (Desktop) --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inventory-items.index')" :active="request()->routeIs('inventory-items.*')">
                {{ __('Inventory') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('manufactures.index')" :active="request()->routeIs('manufactures.*')">
                {{ __('Manufacturing') }}
            </x-responsive-nav-link>
            <!-- Start: Reports Dropdown (Mobile) -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-full text-left px-4 py-2 flex items-center justify-between text-gray-700 dark:text-gray-300 focus:outline-none">
                  <span>{{ __('Reports') }}</span>
                  <svg class="inline-block ms-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" @click.away="open = false" class="z-50 bg-white dark:bg-gray-800 shadow-lg rounded mt-1 w-full absolute left-0">
                  <x-responsive-nav-link :href="route('reports.manufactured', ['from' => now()->toDateString(), 'to' => now()->toDateString()])" :active="request()->routeIs('reports.manufactured')" @click="open = false">
                    {{ __('Manufactured Products') }}
                  </x-responsive-nav-link>
                  <x-responsive-nav-link :href="route('reports.inventoryUsage', ['from' => now()->toDateString(), 'to' => now()->toDateString()])" :active="request()->routeIs('reports.inventoryUsage')" @click="open = false">
                    {{ __('Inventory Usage') }}
                  </x-responsive-nav-link>
                  <x-responsive-nav-link :href="route('reports.inventoryMovements', ['from' => now()->toDateString(), 'to' => now()->toDateString()])" :active="request()->routeIs('reports.inventoryMovements')" @click="open = false">
                    {{ __('Inventory Movements') }}
                  </x-responsive-nav-link>
                </div>
            </div>
            <!-- End: Reports Dropdown (Mobile) -->
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
