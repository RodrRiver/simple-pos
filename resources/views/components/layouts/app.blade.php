<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SimplePOS' }} - SimplePOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- Sidebar overlay (mobile) --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false">
        </div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-[260px] bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:z-auto flex flex-col">
            {{-- Logo --}}
            <div class="flex items-center justify-between h-16 px-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-lg font-bold text-white tracking-tight">SimplePOS</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Quick action --}}
            <div class="px-4 mb-4">
                <a href="{{ route('pos.index') }}" class="flex items-center gap-2 w-full px-4 py-2.5 bg-blue-500 hover:bg-blue-400 text-white rounded-xl text-sm font-medium transition-colors shadow-lg shadow-blue-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Venta
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">
                <p class="px-3 pt-2 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">General</p>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('pos.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Punto de Venta
                </a>

                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('sales.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Ventas
                </a>

                @if(auth()->user()->isAdmin())
                <p class="px-3 pt-5 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Administración</p>

                <a href="{{ route('productos.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('productos.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Productos
                </a>

                <a href="{{ route('categorias.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('categorias.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categorías
                </a>

                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('inventory.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    Inventario
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('reports.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Reportes
                </a>

                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl transition-all {{ request()->routeIs('settings.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Configuración
                </a>
                @endif
            </nav>

            {{-- User info at bottom --}}
            <div class="p-4 border-t border-slate-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-blue-500/10">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->role->value === 'admin' ? 'Administrador' : 'Cajero' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-500 hover:text-red-400 transition-colors" title="Cerrar sesión">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top bar --}}
            <header class="h-16 bg-white border-b border-gray-200/80 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 -ml-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'SimplePOS' }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-400 hidden sm:block">{{ now()->translatedFormat('D d M, Y') }}</span>
                    <a href="{{ route('pos.index') }}" class="hidden sm:flex items-center gap-1.5 text-sm text-blue-600 hover:text-blue-700 font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        POS
                    </a>
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success'))
            <div class="mx-4 lg:mx-8 mt-4" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
                <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            </div>
            @endif
            @if(session('error'))
            <div class="mx-4 lg:mx-8 mt-4" x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            </div>
            @endif

            {{-- Page content --}}
            <main class="flex-1 p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
