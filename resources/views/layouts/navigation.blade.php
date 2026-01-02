<div class="drawer lg:drawer-open">
    <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />
    <input id="sidebar-collapse" type="checkbox" class="hidden" />
    
    <div class="flex flex-col drawer-content">
        <!-- Mobile Menu Button -->
        <div class="p-4 border-b lg:hidden bg-base-100 border-base-300">
            <label for="sidebar-drawer" class="btn btn-square btn-ghost">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </label>
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-base-200">
            <!-- Header Section with Title and Breadcrumb -->
            @php
                $pageTitle = '';
                $breadcrumbs = [];
                
                // Determine page title and breadcrumbs based on current route
                if (request()->routeIs('dashboard')) {
                    $pageTitle = 'Dashboard';
                    $breadcrumbs = [
                        ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                        ['label' => 'Dashboard', 'url' => null, 'active' => true]
                    ];
                } elseif (request()->routeIs('outlet.index')) {
                    $pageTitle = 'Outlet';
                    $breadcrumbs = [
                        ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                        ['label' => 'Business', 'url' => null, 'active' => false],
                        ['label' => 'Outlet', 'url' => null, 'active' => true]
                    ];
                } elseif (request()->routeIs('outlet.create')) {
                    $pageTitle = 'Create Outlet';
                    $breadcrumbs = [
                        ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                        ['label' => 'Business', 'url' => null, 'active' => false],
                        ['label' => 'Outlet', 'url' => route('outlet.index'), 'active' => false],
                        ['label' => 'Create', 'url' => null, 'active' => true]
                    ];
                } elseif (request()->routeIs('outlet.edit')) {
                    $pageTitle = 'Edit Outlet';
                    $breadcrumbs = [
                        ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                        ['label' => 'Business', 'url' => null, 'active' => false],
                        ['label' => 'Outlet', 'url' => route('outlet.index'), 'active' => false],
                        ['label' => 'Edit', 'url' => null, 'active' => true]
                    ];
                } elseif (request()->routeIs('outlet.show')) {
                    $currentOutlet = session('current_outlet') ?? (isset($currentOutlet) ? $currentOutlet : null);
                    $outletName = is_object($currentOutlet) ? $currentOutlet->name : 'Detail';
                    $pageTitle = $outletName;
                    $breadcrumbs = [
                        ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                        ['label' => 'Business', 'url' => null, 'active' => false],
                        ['label' => 'Outlet', 'url' => route('outlet.index'), 'active' => false],
                        ['label' => $outletName, 'url' => null, 'active' => true]
                    ];
                } elseif (request()->routeIs('outlet.services.*')) {
                    $currentOutlet = session('current_outlet') ?? (isset($currentOutlet) ? $currentOutlet : null);
                    
                    if (request()->routeIs('outlet.services.index')) {
                        $pageTitle = 'Services';
                        $breadcrumbs = [
                            ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                            ['label' => 'Business', 'url' => null, 'active' => false],
                            ['label' => 'Outlet', 'url' => route('outlet.index'), 'active' => false],
                            ['label' => 'Services', 'url' => null, 'active' => true]
                        ];
                    } elseif (request()->routeIs('outlet.services.create')) {
                        $pageTitle = 'Create Service';
                        $breadcrumbs = [
                            ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                            ['label' => 'Business', 'url' => null, 'active' => false],
                            ['label' => 'Outlet', 'url' => route('outlet.index'), 'active' => false],
                            ['label' => 'Services', 'url' => route('outlet.services.index', ['outlet' => is_object($currentOutlet) ? $currentOutlet->id : $currentOutlet]), 'active' => false],
                            ['label' => 'Create', 'url' => null, 'active' => true]
                        ];
                    } elseif (request()->routeIs('outlet.services.edit')) {
                        $pageTitle = 'Edit Service';
                        $breadcrumbs = [
                            ['label' => 'Luxe', 'url' => route('dashboard'), 'active' => false],
                            ['label' => 'Business', 'url' => null, 'active' => false],
                            ['label' => 'Outlet', 'url' => route('outlet.index'), 'active' => false],
                            ['label' => 'Services', 'url' => route('outlet.services.index', ['outlet' => is_object($currentOutlet) ? $currentOutlet->id : $currentOutlet]), 'active' => false],
                            ['label' => 'Edit', 'url' => null, 'active' => true]
                        ];
                    }
                }
            @endphp

            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-start justify-between">
                        <!-- Left: Title -->
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $pageTitle }}</h1>
                        </div>

                        <!-- Right: Breadcrumb -->
                        <nav class="flex items-center space-x-2 text-sm text-gray-500">
                            @foreach($breadcrumbs as $index => $crumb)
                                @if($crumb['url'])
                                    <a href="{{ $crumb['url'] }}" class="transition-colors hover:text-teal-600">
                                        {{ $crumb['label'] }}
                                    </a>
                                @else
                                    <span class="{{ $crumb['active'] ? 'text-gray-900 font-medium' : '' }}">
                                        {{ $crumb['label'] }}
                                    </span>
                                @endif
                                
                                @if(!$loop->last)
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Page Heading (for backward compatibility) -->
            @isset($header)
            <div class="border-b bg-base-100 border-base-300">
                <div class="px-6 py-6">
                    {{ $header }}
                </div>
            </div>
            @endisset

            <!-- Main Content Slot -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Sidebar -->
    <div class="drawer-side">
        <label for="sidebar-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        
        <aside id="sidebar" class="flex flex-col w-64 min-h-screen text-white transition-all duration-300 bg-gradient-to-b from-teal-600 via-teal-700 to-teal-800">
            <!-- Logo & Toggle Button -->
            <div class="flex items-center justify-between flex-shrink-0 p-4 border-b border-teal-500/30">
                <a href="{{ route('dashboard') }}" class="transition-opacity duration-300 group" id="logo-text">
                    <h1 class="font-serif text-3xl italic font-bold text-transparent bg-gradient-to-r from-teal-200 to-cyan-200 bg-clip-text">
                        Luxe
                    </h1>
                </a>
                
                <!-- Collapse/Expand Toggle Button -->
                <label for="sidebar-collapse" class="hidden btn btn-ghost btn-sm btn-circle hover:bg-teal-600/50 lg:flex" onclick="toggleSidebar()">
                    <svg id="collapse-icon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </label>
            </div>

            <!-- Navigation Menu (with flex-1 to push user profile to bottom) -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <!-- Overview Section -->
                <div class="px-3 mb-2 sidebar-text">
                    <span class="text-xs font-semibold tracking-wider text-teal-200 uppercase">Overview</span>
                </div>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-teal-500 to-cyan-500 shadow-lg' : 'hover:bg-teal-600/50' }}">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-teal-200' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="font-medium sidebar-text {{ request()->routeIs('dashboard') ? 'text-white' : 'text-teal-100' }}">
                        Dashboard
                    </span>
                </a>

                @auth
                @if(Auth::check() && Auth::user()->hasRole('owner'))
                <!-- Business Section -->
                <div class="px-3 mt-6 mb-2 sidebar-text">
                    <span class="text-xs font-semibold tracking-wider text-teal-200 uppercase">Business</span>
                </div>

                <!-- Outlet -->
                <a href="{{ route('outlet.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('outlet.index') || (request()->routeIs('outlet.*') && !request()->routeIs('outlet.services.*')) ? 'bg-gradient-to-r from-teal-500 to-cyan-500 shadow-lg' : 'hover:bg-teal-600/50' }}">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('outlet.index') || (request()->routeIs('outlet.*') && !request()->routeIs('outlet.services.*')) ? 'text-white' : 'text-teal-200' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="font-medium sidebar-text {{ request()->routeIs('outlet.index') || (request()->routeIs('outlet.*') && !request()->routeIs('outlet.services.*')) ? 'text-white' : 'text-teal-100' }}">
                        Outlet
                    </span>
                </a>

                <!-- Services -->
                @php
                    $currentOutlet = session('current_outlet') ?? (isset($currentOutlet) ? $currentOutlet : null);
                @endphp
                @if($currentOutlet)
                <a href="{{ route('outlet.services.index', ['outlet' => is_object($currentOutlet) ? $currentOutlet->id : $currentOutlet]) }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('outlet.services.*') ? 'bg-gradient-to-r from-teal-500 to-cyan-500 shadow-lg' : 'hover:bg-teal-600/50' }}">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('outlet.services.*') ? 'text-white' : 'text-teal-200' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium sidebar-text {{ request()->routeIs('outlet.services.*') ? 'text-white' : 'text-teal-100' }}">
                        Services
                    </span>
                </a>
                @endif
                @endif
                @endauth
            </nav>

            <!-- User Profile at Bottom (flex-shrink-0 to prevent shrinking) -->
            <div class="flex-shrink-0 p-3 border-t border-teal-500/30">
                <div class="w-full dropdown dropdown-top dropdown-end">
                    <label tabindex="0"
                           class="justify-start w-full h-auto min-h-0 px-3 py-2 normal-case user-profile-btn btn btn-ghost hover:bg-teal-600/50">
                        <div class="flex items-center w-full space-x-3">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 avatar placeholder">
                                <div class="flex items-center justify-center w-10 h-10 text-white rounded-full bg-gradient-to-br from-teal-400 to-cyan-500">
                                    <span class="text-sm font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="flex-1 text-left sidebar-text">
                                <div class="text-sm font-medium text-white">
                                    {{ Auth::user()->name ?? 'Guest' }}
                                </div>
                                <div class="text-xs text-teal-200">
                                    @auth
                                        {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'User') }}
                                    @else
                                        Guest
                                    @endauth
                                </div>
                            </div>

                            <!-- Arrow -->
                            <svg class="w-4 h-4 text-teal-200 transition-transform sidebar-text"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 15l7-7 7 7" />
                            </svg>
                        </div>
                    </label>

                    <!-- Dropdown Menu -->
                    <ul tabindex="0"
                        class="dropdown-content z-[9999] mb-2 w-full min-w-[180px]
                               rounded-xl bg-teal-700 shadow-xl
                               border border-teal-500/30 p-2 space-y-1">

                        <!-- PROFILE -->
                        @if (Route::has('profile.edit'))
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center w-full h-10 gap-3 px-4 text-sm font-medium text-teal-100 transition rounded-lg hover:bg-teal-600/60">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Profile</span>
                                </a>
                            </li>
                        @endif

                        <!-- LOGOUT -->
                        @if (Route::has('logout'))
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center w-full h-10 gap-3 px-4 text-sm font-medium text-teal-100 transition rounded-lg hover:bg-red-500/80">
                                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
/* Sidebar collapsed state */
#sidebar.collapsed {
    width: 80px !important;
}

#sidebar.collapsed .sidebar-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
    transition: opacity 0.3s ease, width 0.3s ease;
}

#sidebar.collapsed #logo-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

#sidebar.collapsed .dropdown {
    position: relative;
}

#sidebar.collapsed .dropdown-content {
    left: 100%;
    margin-left: 0.5rem;
    bottom: 0;
}

#sidebar:not(.collapsed) .sidebar-text {
    opacity: 1;
    transition: opacity 0.3s ease 0.2s;
}

/* Rotate icon when collapsed */
#sidebar.collapsed #collapse-icon {
    transform: rotate(180deg);
}

/* Limit chart/graph container height */
[id*="chart"], 
[class*="chart-container"],
.apexcharts-canvas,
canvas {
    max-height: 400px !important;
}

/* Specific for common chart libraries */
.chartjs-render-monitor,
.apexcharts-svg {
    max-height: 400px !important;
}

/* Container untuk chart sections */
div:has(> canvas),
div:has(> .apexcharts-canvas) {
    max-height: 450px !important;
    overflow: hidden;
}
</style>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
    
    // Save state to localStorage
    if (sidebar.classList.contains('collapsed')) {
        localStorage.setItem('sidebarCollapsed', 'true');
    } else {
        localStorage.setItem('sidebarCollapsed', 'false');
    }
}

// Load saved state on page load
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
    }
});
</script>