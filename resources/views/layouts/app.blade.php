<!DOCTYPE html>
<html x-data="layout()" x-init="init()">

@php
    $user = Auth::user();
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>paf</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('scripts')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body class="h-screen flex flex-col overflow-hidden">

    <!-- HEADER -->
    <div class="flex flex-col flex-shrink-0">
        <div id="mainHeader" class="h-16 flex items-center px-3 bg-gray-50">
            <div class="text-black flex items-center gap-2">
                <!-- Sidebar toggle -->
                <div class="p-3 rounded-full hover:bg-gray-100 cursor-pointer" @click="toggleSidebar()">
                    <x-radix-hamburger-menu class="w-8 h-8" />
                </div>

                <img src="{{ asset('img/logo_paf.png') }}" alt="" class="h-8 lg:h-10">

                @hasSection('breadcrumb')
                    <div class="px-4 lg:h-10 h-8 text-sm text-gray-500 flex items-center gap-2">
                        @yield('breadcrumb')
                    </div>
                @endif
            </div>

            <div class="flex-1"></div>

            <div class="flex flex-row items-center gap-2 ">
                <!-- Plus Button -->
                <div class="p-3 rounded-full hover:bg-gray-100 cursor-pointer"
                    @click="$dispatch('open-modal-associate-feeder')">
                    <x-radix-plus class="w-6 h-6" />
                </div>

                <!-- USER DROPDOWN -->
                <div class="relative  " x-data="userDropdown()" x-cloak>
                    @if(empty($user->avatar))
                    <div class="cursor-pointer text-white rounded-full h-10 w-10 bg-gray-600 flex justify-center items-center select-none"
                        @click="toggle()">
                        {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    @else
                    <div
                    class="cursor-pointer text-white rounded-full h-10 w-10 bg-center bg-cover flex justify-center items-center select-none"
                    style="background-image: url('{{ $user->avatar }}')"
                    @click="toggle()">
                </div>
                    @endif

                    <div x-show="show" x-transition.origin.top.right @click.outside="close()"
                    class="absolute right-0 mt-3 w-80 z-50" x-cloak>
                        <div class="bg-white shadow-lg rounded-xl p-4">
                            <div class="relative flex font-semibold justify-center items-center">
                                <div class="text-center w-full">{{ Auth::user()->email }}</div>
                                <div @click="close()" class="absolute right-0 cursor-pointer">
                                    <x-radix-cross-2 class="h-5 w-5" />
                                </div>
                            </div>

                            <div class="flex justify-center mt-3">
                                @if(empty($user->avatar))
                                <div
                                    class="text-white text-xl rounded-full h-16 w-16 bg-gray-600 flex items-center justify-center">
                                    {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                @else
                                <div
                                class="text-white text-xl rounded-full h-16 w-16 flex items-center justify-center bg-center bg-cover" style="background-image: url('{{ $user->avatar }}')">
                            </div>
                            @endif
                            </div>
                            

                            <div class="text-center mt-2 text-lg">
                                Olá, {{ Auth::user()->name }}
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="w-full rounded-xl bg-gray-200 py-2 hover:bg-gray-300 transition">
                                    Sair da conta
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @php
    $sections = [
        [
            'name' => __('navbar.dashboard'),
            'icon' => 'home-outline',
            'url' => route("home")
        ],
        [
            'name' => __('navbar.schedules'),
            'icon' => 'calendar-clock-outline',
            'url' => route("schedule"),
            'need_feeder' => true
        ],
        [
            'name' => __('navbar.feeders'),
            'icon' => 'paw-outline',
            'url' => route("feeder.index"),
            'need_feeder' => true
        ],
        [
            'name' => __('navbar.settings'),
            'icon' => 'cog',
            'url' => route("settings.index")
        ],
                    [
            'name' => __('navbar.admin'),
            'icon' => 'crown',
            'url' => route("admin.index"),
            'role' => 'admin'
        ],

];
    @endphp
    <!-- MAIN LAYOUT -->
    <div class="flex-1 flex min-h-0 overflow-hidden">

        <!-- MOBILE SIDEBAR OVERLAY -->
        <div class="fixed inset-0 z-40 bg-[rgba(0,0,0,0.5)] md:hidden" x-show="sidebarOpen" x-transition.opacity
            @click="toggleSidebar(false)" x-cloak></div>

        <!-- MOBILE SIDEBAR -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-50 p-4 pt-0 flex flex-col gap-y-6 transform transition-transform duration-300 md:hidden min-h-screen">

            <div class="flex h-16 items-center">
                <button @click="toggleSidebar(false)" class="p-2 rounded-full hover:bg-gray-200">
                    <x-radix-cross-2 class="h-8 w-8" />
                </button>
                <img src="{{ asset('img/logo_paf.png') }}" alt="" class="h-8 lg:h-12 ml-2">
            </div>
            @foreach ($sections as $section)
    
            @if(!isset($section['need_feeder']) || ($section['need_feeder'] && $user->hasFeeders()))
    
                @if(!isset($section['role']) || $user->role == $section['role'])
    
                    <a href="{{ $section['url'] }}"
                    class="sidebar-item flex items-center w-full gap-2 px-2 py-2 rounded-full hover:bg-gray-200
                    {{ Request::url() === $section['url'] ? 'bg-gray-300' : '' }}">
    
                        <x-dynamic-component :component="'mdi-' .$section['icon']" class="h-8 w-8 flex-shrink-0" />
    
                        <span
                            class="text-gray-700 font-medium">
                            {{ $section['name'] }}
                        </span>
    
                    </a>
    
                @endif
    
            @endif
    
        @endforeach

            
        </div>


        <!-- DESKTOP SIDEBAR -->
        <div id="sidebar" :class="{ 'hover': sidebarOpen, 'no-transition': noTransition }"
        class="hidden md:flex flex-col justify-start items-center pt-3 pb-2 bg-gray-50 px-4 gap-y-6 w-16 hover:w-56 not-hover:duration-1000 duration-600 not-hover:w-16 ease-in-out group min-h-screen" x-cloak>
    
        @foreach ($sections as $section)
    
            @if(!isset($section['need_feeder']) || ($section['need_feeder'] && $user->hasFeeders()))
    
                @if(!isset($section['role']) || $user->role == $section['role'])
    
                    <a href="{{ $section['url'] }}"
                       class="sidebar-item not-hover:duration-1000 flex items-center w-12 hover:bg-gray-200 rounded-full px-2 py-2 transition-all duration-300 ease-in-out group-hover:w-full overflow-hidden cursor-pointer
                       {{ Request::url() === $section['url'] ? 'bg-gray-300' : '' }}">
    
                        <x-dynamic-component :component="'mdi-' .$section['icon']" class="h-8 w-8 flex-shrink-0" />
    
                        <span
                            class="text-gray-700 font-medium opacity-0 transform translate-x-[1rem] group-hover:opacity-100 transition-all duration-300 whitespace-nowrap">
                            {{ $section['name'] }}
                        </span>
    
                    </a>
    
                @endif
    
            @endif
    
        @endforeach
    
    </div>

        <!-- CONTENT -->
        <div class="flex flex-col flex-1 min-h-0 overflow-hidden">

            <div class="hidden md:block bg-gray-50 w-full">
                <div class="bg-white h-5 rounded-tl-full"></div>
            </div>

            <div class="flex-1 overflow-y-auto px-0.5 mt-3 mb-3 md:mt-0">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg shadow">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('body')
            </div>

        </div>

    </div>

    <!-- STYLES -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .no-transition,
        .no-transition *,
        .no-transition *::before,
        .no-transition *::after {
            transition: none !important;
            animation: none !important;
        }

        /* sidebar forced open (when sidebarOpen = true) */
        #sidebar.hover {
            width: 14rem;
            transition: width 0.3s ease-in-out;
        }

        /* items expand */
        #sidebar.hover .sidebar-item {
            width: 100%;
        }

        /* show text */
        #sidebar.hover .sidebar-item span {
            opacity: 1;
            transform: translateX(0);
        }

        /* keep hover behaviour */
        #sidebar:hover {
            width: 14rem;
        }

        #sidebar:hover .sidebar-item {
            width: 100%;
        }

        #sidebar:hover .sidebar-item span {
            opacity: 1;
            transform: translateX(0);
        }
    </style>

    <!-- SCRIPTS -->
    <script>
        function layout() {
            return {
                sidebarOpen: false,
                noTransition: false, // New property
                initialized: false,
                init() {
                    const isDesktop = window.innerWidth >= 768;
                    if (isDesktop) {
                        const saved = sessionStorage.getItem('sidebarOpen');
                        if (saved === 'true') {
                            // Disable transitions temporarily
                            this.noTransition = true;
                            this.sidebarOpen = true;

                            // Re-enable transitions after the initial render
                            this.$nextTick(() => {
                                setTimeout(() => {
                                    this.noTransition = false;
                                }, 50);
                            });
                        }
                    } else {
                        this.sidebarOpen = false;
                    }
                    this.initialized = true;

                    window.addEventListener('resize', () => {
                        const desktop = window.innerWidth >= 768;
                        if (desktop && sessionStorage.getItem('sidebarOpen') !== null) {
                            this.sidebarOpen = sessionStorage.getItem('sidebarOpen') === 'true';
                        } else if (!desktop) {
                            this.sidebarOpen = false;
                        }
                    });
                },
                toggleSidebar(force = null) {
                    const isDesktop = window.innerWidth >= 768;
                    if (force === null) this.sidebarOpen = !this.sidebarOpen;
                    else this.sidebarOpen = force;

                    if (isDesktop) {
                        sessionStorage.setItem('sidebarOpen', this.sidebarOpen);
                    }
                }
            }
        }

        function userDropdown() {
            return {
                show: false,
                toggle() {
                    this.show = !this.show
                },
                close() {
                    this.show = false
                }
            }
        }
    </script>

</body>

</html>

<x-modal />
