<nav x-data="{ open: false }" class="bg-success border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo style="height: 3rem" class="block w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if (auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white font-bold">
                            <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.manage-users')" :active="request()->routeIs('admin.manage-users')" class="text-white font-bold">
                            <i class="fas fa-users me-2"></i>{{ __('Manage Users') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.crops.index')" :active="request()->routeIs('admin.crops.index')" class="text-white font-bold">
                            <i class="fas fa-seedling me-2"></i>{{ __('View Crops') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.crop_reports.index')" :active="request()->routeIs('admin.crop_reports.index')" class="text-white font-bold">
                            <i class="fas fa-clipboard-list me-2"></i>{{ __('View Crop Reports') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.damage_reports.index')" :active="request()->routeIs('admin.damage_reports.index')" class="text-white font-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('View Damage Reports') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.logs.index')" :active="request()->routeIs('admin.logs.index')" class="text-white font-bold">
                            <i class="fas fa-history me-2"></i>{{ __('View Logs') }}
                        </x-nav-link>
                    @elseif(auth()->user()->role === 'user')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white font-bold">
                            <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('crops.index')" :active="request()->routeIs('crops.index')" class="text-white font-bold">
                            <i class="fas fa-seedling me-2"></i>{{ __('Manage Crops') }}
                        </x-nav-link>
                        <x-nav-link :href="route('crop_reports.index')" :active="request()->routeIs('crop_reports.index')" class="text-white font-bold">
                            <i class="fas fa-clipboard-list me-2"></i>{{ __('Manage Crop Reports') }}
                        </x-nav-link>
                        <x-nav-link :href="route('damage_reports.index')" :active="request()->routeIs('damage_reports.index')" class="text-white font-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Manage Damage Reports') }}
                        </x-nav-link>
                    @endif
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold">
                            <i class="fas fa-user me-2"></i>{{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                class="font-bold">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <style>
        /* Active link color */
        .nav-color .active-link {
            color: black !important;
        }

        /* Hover effect for all links */
        .nav-color .text-white:hover {
            color: black !important;
        }
    </style>


    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="nav-color pt-2 pb-3 space-y-1">
            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                    class="text-white font-bold {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.crops.index')" :active="request()->routeIs('admin.crops.index')"
                    class="text-white font-bold {{ request()->routeIs('admin.crops.index') ? 'active-link' : '' }}">
                    <i class="fas fa-seedling me-2"></i>{{ __('View Crops') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.crop_reports.index')" :active="request()->routeIs('admin.crop_reports.index')"
                    class="text-white font-bold {{ request()->routeIs('admin.crop_reports.index') ? 'active-link' : '' }}">
                    <i class="fas fa-clipboard-list me-2"></i>{{ __('View Crop Reports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.damage_reports.index')" :active="request()->routeIs('admin.damage_reports.index')"
                    class="text-white font-bold {{ request()->routeIs('admin.damage_reports.index') ? 'active-link' : '' }}">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ __('View Damage Reports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.logs.index')" :active="request()->routeIs('admin.logs.index')"
                    class="text-white font-bold {{ request()->routeIs('admin.logs.index') ? 'active-link' : '' }}">
                    <i class="fas fa-history me-2"></i>{{ __('View Logs') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->role === 'user')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="text-white font-bold {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('crops.index')" :active="request()->routeIs('crops.index')"
                    class="text-white font-bold {{ request()->routeIs('crops.index') ? 'active-link' : '' }}">
                    <i class="fas fa-seedling me-2"></i>{{ __('Manage Crops') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('crop_reports.index')" :active="request()->routeIs('crop_reports.index')"
                    class="text-white font-bold {{ request()->routeIs('crop_reports.index') ? 'active-link' : '' }}">
                    <i class="fas fa-clipboard-list me-2"></i>{{ __('Manage Crop Reports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('damage_reports.index')" :active="request()->routeIs('damage_reports.index')"
                    class="text-white font-bold {{ request()->routeIs('damage_reports.index') ? 'active-link' : '' }}">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Manage Damage Reports') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>

            <div class="nav-color mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white font-bold">
                    <i class="fas fa-user me-2"></i>{{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="text-white font-bold">
                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
