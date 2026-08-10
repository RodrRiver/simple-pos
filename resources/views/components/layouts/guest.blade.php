<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SimplePOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex">
    {{-- Left panel - branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-2xl font-bold tracking-tight">SimplePOS</span>
            </div>
        </div>
        <div class="relative z-10">
            <h1 class="text-4xl font-bold leading-tight mb-4">Tu negocio,<br>bajo control.</h1>
            <p class="text-blue-200 text-lg leading-relaxed max-w-md">Sistema de punto de venta e inventario simple, rápido y diseñado para tu negocio.</p>
            <div class="mt-8 flex gap-6">
                <div>
                    <p class="text-3xl font-bold">100%</p>
                    <p class="text-blue-200 text-sm">Gratis</p>
                </div>
                <div class="w-px bg-blue-400/30"></div>
                <div>
                    <p class="text-3xl font-bold">2</p>
                    <p class="text-blue-200 text-sm">Roles</p>
                </div>
                <div class="w-px bg-blue-400/30"></div>
                <div>
                    <p class="text-3xl font-bold">PDF</p>
                    <p class="text-blue-200 text-sm">Recibos</p>
                </div>
            </div>
        </div>
        <div class="relative z-10">
            <p class="text-blue-300 text-sm">Open Source &mdash; MIT License</p>
        </div>
    </div>

    {{-- Right panel - form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">SimplePOS</span>
                </div>
                <p class="text-gray-500 text-sm">Sistema de Punto de Venta</p>
            </div>
            {{ $slot }}
        </div>
    </div>
</body>
</html>
