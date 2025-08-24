<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Restaurant Admin')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui']
                    },
                    borderRadius: {
                        xl2: '1.25rem'
                    },
                    boxShadow: {
                        card: '0 4px 12px rgba(0,0,0,.06)',
                        'card-dark': '0 4px 12px rgba(0,0,0,.25)'
                    },
                    colors: {
                        primary: '#6366f1'
                    }
                }
            }
        };
    </script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        body {
            background: radial-gradient(circle at 50% 0%, #eceef1 0%, #f7f7f9 60%);
        }

        .dark body {
            background: radial-gradient(circle at 50% 0%, #1f2937 0%, #111827 60%);
        }

        /* Layout Container - Fixed height */
        .layout-container {
            height: 100vh;
            overflow: hidden;
        }
        
        /* Sidebar Container - Fixed width and height */
        .sidebar-container {
            height: 100vh;
            width: 16rem; /* w-64 = 16rem */
            flex-shrink: 0;
        }
        
        /* Main Content Container - Independent scrolling */
        .main-content-container {
            height: 100vh;
            overflow-y: auto;
            flex: 1;
        }

        /* Sidebar Fixed Height */
        .sidebar-fixed {
            height: 100vh;
            overflow-y: auto;
        }

        /* Custom Scrollbars */
        .sidebar-fixed::-webkit-scrollbar,
        .main-content-container::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-fixed::-webkit-scrollbar-track,
        .main-content-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-fixed::-webkit-scrollbar-thumb,
        .main-content-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 2px;
        }

        .dark .sidebar-fixed::-webkit-scrollbar-thumb,
        .dark .main-content-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Mobile Responsive */
        @media (max-width: 1023px) {
            .layout-container {
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }
            
            .main-content-container {
                height: auto;
                overflow: visible;
            }
        }
    </style>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=IBM+Plex+Serif:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@300;400;500;600;700&family=Inter&display=swap"
        rel="stylesheet">

    @stack('styles')
</head>

<body class="font-sans text-gray-900 dark:text-gray-100 antialiased transition-colors duration-200">
    <div class="layout-container flex">

        <!-- Mobile Menu Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

        <!-- Sidebar Container -->
        <div class="sidebar-container">
            <aside id="sidebar"
                class="w-64 bg-white dark:bg-gray-800 shadow-lg dark:shadow-card-dark px-6 py-8 flex flex-col space-y-8 fixed lg:static z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 border-r border-white/5 sidebar-fixed">

                <!-- Header -->
                <div class="flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('FinalIconpng.png') }}" class="w-12 h-12">
                        <div class="flex-1">
                            <p class="font-semibold text-sm">sizzle & spice</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->name ?? 'Admin' }}</p>
                        </div>
                    </div>
                    <button id="close-sidebar" class="lg:hidden p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" data-lucide="x" class="lucide lucide-x w-5 h-5">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation - Scrollable Area -->
                <nav class="space-y-8 text-sm flex-1 min-h-0">

                    <!-- Core Management -->
                    <div>
                        <p class="uppercase text-xs text-gray-400 dark:text-gray-500 mb-3 font-medium">Core Management</p>
                        <ul class="space-y-1">
                            <li><a class="flex items-center gap-3 {{ request()->routeIs('home*') ? 'font-medium text-primary bg-indigo-50 dark:bg-indigo-900/30 border border-white/5' : 'hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700' }} px-3 py-2 rounded-lg transition-colors"  href="{{ route('home') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard w-4 h-4">
                                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                                </svg>Dashboard</a></li>
                            
                            <li><a class="flex items-center gap-3 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors" href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4">
                                    <circle cx="8" cy="21" r="1"></circle>
                                    <circle cx="19" cy="21" r="1"></circle>
                                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                                </svg>Orders<span class="ml-auto text-[10px] bg-red-500 text-white px-1.5 py-0.5 rounded-full">5</span></a></li>
                            
                            <li>
                                <a class="flex items-center gap-3 {{ request()->routeIs('table*') ? 'font-medium text-primary bg-indigo-50 dark:bg-indigo-900/30 border border-white/5' : 'hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700' }} px-3 py-2 rounded-lg transition-colors" 
                                href="{{ route('table') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-armchair w-4 h-4">
                                    <path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3"></path>
                                    <path d="M2 16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v1.5a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5V11a2 2 0 0 0-4 0z"></path>
                                    <path d="M4 18v2"></path>
                                    <path d="M20 18v2"></path>
                                </svg>Tables</a></li>
                            
                            <li>
                                <a class="flex items-center gap-3 {{ request()->routeIs('menu*') ? 'font-medium text-primary bg-indigo-50 dark:bg-indigo-900/30 border border-white/5' : 'hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700' }} px-3 py-2 rounded-lg transition-colors" 
                                href="{{ route('menu') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-utensils w-4 h-4">
                                        <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path>
                                        <path d="M7 2v20"></path>
                                        <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3z"></path>
                                    </svg>Menu
                                </a>
                            </li>

                        </ul>
                    </div>

                    <!-- Operations -->
                    <div>
                        <p class="uppercase text-xs text-gray-400 dark:text-gray-500 mb-3 font-medium">Operations</p>
                        <ul class="space-y-4 pl-4 border-l border-gray-200 dark:border-gray-700">
                            <li class="flex items-center gap-2 text-sm">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                <a href="" class="hover:text-primary">Current Orders</a>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                <a href="" class="hover:text-primary">Reservations</a>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                <a href="" class="hover:text-primary">Order History</a>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                <a href="" class="hover:text-primary">Delivery/Takeout Tracking</a>
                            </li>
                        </ul>
                    </div>

                    <!-- People & Analytics -->
                    <div>
                        <p class="uppercase text-xs text-gray-400 dark:text-gray-500 mb-3 font-medium">People & Analytics</p>
                        <ul class="space-y-1">
                            <li><a class="flex items-center gap-3 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors" href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-4 h-4">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>Customers</a></li>
                            
                            <li><a class="flex items-center gap-3 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors" href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-tie w-4 h-4">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M15 2l5 5-5 5"></path>
                                    <path d="M22 12H9"></path>
                                </svg>Staff</a></li>
                            
                            <li><a class="flex items-center gap-3 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors" href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bar-chart-3 w-4 h-4">
                                    <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                    <path d="M18 17V9"></path>
                                    <path d="M13 17V5"></path>
                                    <path d="M8 17v-3"></path>
                                </svg>Analytics</a></li>
                        </ul>
                    </div>

                </nav>

                <!-- Footer - Fixed at bottom -->
                <div class="border-t dark:border-gray-700 pt-4 space-y-2 flex-shrink-0">
                    <button class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 hover:text-red-500 w-full px-3 py-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="settings" class="lucide lucide-settings w-4 h-4">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>Settings</button>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 w-full px-3 py-2 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="log-out" class="lucide lucide-log-out w-4 h-4">
                                <path d="m16 17 5-5-5-5"></path>
                                <path d="M21 12H9"></path>
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            </svg>Sign Out
                        </button>
                    </form>

                </div>

            </aside>
        </div>

        <!-- Main Content Container -->
        <main class="main-content-container lg:p-12 pt-4 pr-4 pb-4 pl-4">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
    <script>
        lucide.createIcons();

        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
            });
        }

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        }

        // Mobile menu
        const mobileMenu = document.getElementById('mobile-menu');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        if (mobileMenu) {
            mobileMenu.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            });
        }

        [closeSidebar, overlay].forEach(el => {
            if (el) {
                el.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
        });
    </script>
</body>

</html>
