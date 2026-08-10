<x-layouts.app title="Reportes">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Reportes</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('reports.sales') }}" class="bg-white rounded-xl border border-gray-200 p-6 hover:border-blue-300 hover:shadow-sm transition-all">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1">Reporte de Ventas</h3>
            <p class="text-sm text-gray-500">Ventas diarias por rango de fechas.</p>
        </a>

        <a href="{{ route('reports.products') }}" class="bg-white rounded-xl border border-gray-200 p-6 hover:border-blue-300 hover:shadow-sm transition-all">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1">Productos más vendidos</h3>
            <p class="text-sm text-gray-500">Ranking por cantidad y ventas.</p>
        </a>

        <a href="{{ route('reports.profits') }}" class="bg-white rounded-xl border border-gray-200 p-6 hover:border-blue-300 hover:shadow-sm transition-all">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1">Ganancias</h3>
            <p class="text-sm text-gray-500">Ingresos, costos y márgenes.</p>
        </a>
    </div>
</x-layouts.app>
