<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-sm border-b border-slate-200 shadow-lg relative z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent hover:scale-105 transition-transform duration-200">
                        🎓 School Application System
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-slate-700 hover:text-blue-600 transition-all duration-200 font-semibold">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.applications.index')" :active="request()->routeIs('admin.applications.*')" class="text-slate-700 hover:text-blue-600 transition-all duration-200 font-semibold">
                                {{ __('Applications') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.programs.index')" :active="request()->routeIs('admin.programs.*')" class="text-slate-700 hover:text-blue-600 transition-all duration-200 font-semibold">
                                {{ __('Programs') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="text-slate-700 hover:text-blue-600 transition-all duration-200 font-semibold">
                                {{ __('Student Dashboard') }}
                            </x-nav-link>
                            @if(!auth()->user()->applications()->exists())
                                <x-nav-link :href="route('student.application.create')" :active="request()->routeIs('student.application.create')" class="text-slate-700 hover:text-blue-600 transition-all duration-200 font-semibold">
                                    {{ __('Apply Now') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6" x-data="{ open: false }">
                <div class="relative">
                    <button @click="open = !open" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3 shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-blue-100">({{ ucfirst(Auth::user()->role) }})</div>
                            </div>
                        </div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl py-1 z-[9999] border border-gray-200">
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
                            {{ __('Profile') }}
                        </a>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-blue-600 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-blue-600 transition duration-150 ease-in-out">
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
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.applications.index')" :active="request()->routeIs('admin.applications.*')" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                        {{ __('Applications') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.programs.index')" :active="request()->routeIs('admin.programs.*')" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                        {{ __('Programs') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                        {{ __('Student Dashboard') }}
                    </x-responsive-nav-link>
                    @if(!auth()->user()->applications()->exists())
                        <x-responsive-nav-link :href="route('student.application.create')" :active="request()->routeIs('student.application.create')" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                            {{ __('Apply Now') }}
                        </x-responsive-nav-link>
                    @endif
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-slate-700 hover:text-blue-600 transition-all duration-200">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
