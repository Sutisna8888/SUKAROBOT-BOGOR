<nav id="main-navbar" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            
            <div class="flex items-center space-x-2">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/elearning/client/img/logo_sukarobto_bogor.png') }}" alt="Logo" class="w-44 sm:w-52 max-w-[200px] h-auto object-contain">
                </a>
            </div>

            
            <div class="nav hidden lg:flex items-center space-x-8">
                
                <a href="{{ url('/') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Home</a>
                
               

                <a href="{{ url('/program') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Program</a>
                
                  <a href="https://katalog.sukarobot.com/" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors" target="_blank">Katalog</a>

                
                <div class="relative group">
                    <button class="flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors focus:outline-none cursor-pointer py-1">
                        Kompetisi <span class="ml-1"></span>
                    </button>
                    <div class="absolute left-0 top-full mt-1.5 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0 z-50 before:content-[''] before:absolute before:-top-2 before:left-0 before:w-full before:h-2">
                        
                        <div class="relative nav-submenu-container group/sub">
                            <div class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer select-none">
                                <span>BRC</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover/sub:text-blue-600 group-hover/sub:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            
                            <div class="nav-submenu absolute left-full top-0 ml-1 w-36 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200 transform translate-x-1 group-hover/sub:translate-x-0 z-50 before:content-[''] before:absolute before:top-0 before:-left-2 before:w-2 before:h-full">
                                <a href="#" class="block px-3.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 transition-colors">2025</a>
                                <a href="https://brc.sukarobot.com/" target="_blank" rel="noopener noreferrer" class="block px-3.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 transition-colors">2026</a>
                                <a href="#" class="block px-3.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 transition-colors">2027</a>
                            </div>
                        </div>

                        
                        <div class="relative nav-submenu-container group/sub">
                            <div class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer select-none">
                                <span>BSE<span class="text-xs">&</span>C</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover/sub:text-blue-600 group-hover/sub:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            
                            <div class="nav-submenu absolute left-full top-0 ml-1 w-36 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200 transform translate-x-1 group-hover/sub:translate-x-0 z-50 before:content-[''] before:absolute before:top-0 before:-left-2 before:w-2 before:h-full">
                                <a href="#" class="block px-3.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 transition-colors">2025</a>
                                <a href="#" class="block px-3.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 transition-colors">2026</a>
                                <a href="#" class="block px-3.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 transition-colors">2027</a>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="relative group">
                    <button class="flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors focus:outline-none cursor-pointer py-1">
                        Tentang Sukarobot <span class="ml-1"></span>
                    </button>
                    <div class="absolute left-0 top-full mt-1.5 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0 z-50 before:content-[''] before:absolute before:-top-2 before:left-0 before:w-full before:h-2">
                        <a href="{{ url('/instruktur') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Instruktur</a>
                        <a href="{{ url('/tentang') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Tentang Kami</a>
                    </div>
                </div>

                
                <a href="{{ url('/artikel') }}" class="text-sm font-medium {{ request()->is('artikel*') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }} transition-colors">Artikel</a>

                
                <a href="{{ url('/galeri') }}" class="text-sm font-medium {{ request()->is('galeri*') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }} transition-colors">Galeri</a>

                
                @guest
                    <a href="{{ url('/login') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30">
                        Masuk
                    </a>
                @endguest

                @auth
                    
                    <div class="relative group">
                        <button class="flex items-center gap-2 focus:outline-none cursor-pointer">
                            <img src="{{ Auth::user()->avatar_url }}" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                        </button>
                        <div class="absolute right-0 top-full mt-1.5 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0 z-50 before:content-[''] before:absolute before:-top-2 before:left-0 before:w-full before:h-2">
                            @if(Auth::user()->role === 'instructor')
                                <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50">Profil Saya</a>
                                <a href="{{ route('client.notifications.index') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50"><span>Notifikasi</span>@if($unreadNotificationCount > 0)<span class="rounded-full bg-red-500 px-1.5 py-0.5 text-xs font-bold text-white">{{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}</span>@endif</a>
                                <a href="{{ route('instructor.dashboard') }}?welcome=1" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50">Dashboard Instruktur</a>
                            @else
                                <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50">Profil Saya</a>
                                <a href="{{ route('client.notifications.index') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50"><span>Notifikasi</span>@if($unreadNotificationCount > 0)<span class="rounded-full bg-red-500 px-1.5 py-0.5 text-xs font-bold text-white">{{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}</span>@endif</a>
                                <a href="{{ route('client.become-instructor') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50">Menjadi Instruktur</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 cursor-pointer">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            
            <div class="lg:hidden">
                <button id="mobile-menu-btn" class="text-gray-600 focus:outline-none p-2 cursor-pointer">
                    <svg id="icon-menu" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg id="icon-close" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    
    <div id="mobile-menu" class="hidden lg:hidden absolute top-full left-0 w-full bg-white shadow-lg border-t max-h-[80vh] overflow-y-auto">
        <div class="px-4 py-6 space-y-4 flex flex-col">
            <a href="{{ url('/') }}" class="text-base font-medium text-gray-700 hover:text-blue-600">Home</a>
            
             <a href="https://katalog.sukarobot.com/" class="text-base font-medium text-gray-700 hover:text-blue-600">Katalog</a>

            <a href="{{ url('/program') }}" class="text-base font-medium text-gray-700 hover:text-blue-600">Program</a>

            <div>
                <button class="w-full flex justify-between items-center text-base font-medium text-gray-700 hover:text-blue-600 mobile-dropdown-btn cursor-pointer">
                    <span>Kompetisi</span> <span class="arrow-icon transition-transform duration-200">â–¾</span>
                </button>
                <div class="hidden mt-2 pl-3 space-y-2 mobile-dropdown-content border-l-2 border-gray-100 ml-1">
                    
                    <div>
                        <button class="w-full flex justify-between items-center text-sm font-medium text-gray-600 hover:text-blue-600 mobile-dropdown-btn py-1 cursor-pointer">
                            <span>BRC</span> <span class="arrow-icon transition-transform duration-200 text-xs">â–¾</span>
                        </button>
                        <div class="hidden mt-1 pl-3 space-y-1 mobile-dropdown-content border-l border-blue-100 ml-1">
                            <a href="#" class="block text-xs font-medium text-gray-600 hover:text-blue-600 py-1">2025</a>
                            <a href="https://brc.sukarobot.com/" target="_blank" rel="noopener noreferrer" class="block text-xs font-medium text-gray-600 hover:text-blue-600 py-1">2026</a>
                            <a href="#" class="block text-xs font-medium text-gray-600 hover:text-blue-600 py-1">2027</a>
                        </div>
                    </div>

                    
                    <div>
                        <button class="w-full flex justify-between items-center text-sm font-medium text-gray-600 hover:text-blue-600 mobile-dropdown-btn py-1 cursor-pointer">
                            <span>BSE<span class="text-xs">&</span>C</span> <span class="arrow-icon transition-transform duration-200 text-xs">â–¾</span>
                        </button>
                        <div class="hidden mt-1 pl-3 space-y-1 mobile-dropdown-content border-l border-blue-100 ml-1">
                            <a href="#" class="block text-xs font-medium text-gray-600 hover:text-blue-600 py-1">2025</a>
                            <a href="#" class="block text-xs font-medium text-gray-600 hover:text-blue-600 py-1">2026</a>
                            <a href="#" class="block text-xs font-medium text-gray-600 hover:text-blue-600 py-1">2027</a>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button class="w-full flex justify-between items-center text-base font-medium text-gray-700 hover:text-blue-600 mobile-dropdown-btn cursor-pointer">
                    <span>Tentang Sukarobot</span> <span class="arrow-icon transition-transform duration-200">â–¾</span>
                </button>
                <div class="hidden mt-2 pl-3 space-y-2 mobile-dropdown-content border-l-2 border-gray-100 ml-1">
                    <a href="{{ url('/instruktur') }}" class="block text-sm font-medium text-gray-600 hover:text-blue-600">Instruktur</a>
                    <a href="{{ url('/tentang') }}" class="block text-sm font-medium text-gray-600 hover:text-blue-600">Tentang Kami</a>
                </div>
            </div>

            <a href="{{ url('/artikel') }}" class="text-base font-medium {{ request()->is('artikel*') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">Artikel</a>
            <a href="{{ url('/galeri') }}" class="text-base font-medium {{ request()->is('galeri*') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">Galeri</a>

            @guest
                <a href="{{ url('/login') }}" class="w-full bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold text-center block hover:bg-blue-700 transition-colors">
                    Masuk
                </a>
            @endguest

            @auth
                <div class="pt-4 border-t border-gray-300">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ Auth::user()->avatar_url }}" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-medium text-gray-900">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('client.dashboard') }}" class="w-full bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold text-center block hover:bg-blue-700 transition-colors mb-3">Profil Saya</a>
                    
                    <a href="{{ route('client.notifications.index') }}" class="w-full bg-white text-blue-600 border-2 border-blue-600 px-6 py-3 rounded-xl font-semibold text-center block hover:bg-blue-50 transition-colors mb-3">Notifikasi @if($unreadNotificationCount > 0)<span class="ml-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white">{{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}</span>@endif</a>
                    
                    @if(Auth::user()->role === 'instructor')
                        <a href="{{ route('instructor.dashboard') }}?welcome=1" class="w-full bg-white text-blue-600 border-2 border-blue-600 px-6 py-3 rounded-xl font-semibold text-center block hover:bg-blue-50 transition-colors mb-3">Dashboard Instruktur</a>
                    @else
                        <a href="{{ route('client.become-instructor') }}" class="w-full bg-white text-blue-600 border-2 border-blue-600 px-6 py-3 rounded-xl font-semibold text-center block hover:bg-blue-50 transition-colors mb-3">Menjadi Instruktur</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-xl font-semibold text-center block hover:bg-red-700 transition-colors cursor-pointer">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

<link rel="stylesheet" href="{{ asset('assets/elearning/client/css/partials/navbar.css') }}">
