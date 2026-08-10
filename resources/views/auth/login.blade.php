<x-layouts.guest>
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Bienvenido</h2>
        <p class="text-gray-500 text-sm mb-8">Ingresa tus credenciales para acceder al sistema.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Correo electrónico</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="tu@correo.com"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white transition-shadow hover:shadow-sm">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white transition-shadow hover:shadow-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-600">Recordarme</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm shadow-sm hover:shadow-md active:scale-[0.99]">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-100">
            <p class="text-xs font-medium text-blue-700 mb-2">Credenciales de demostración</p>
            <div class="grid grid-cols-2 gap-3 text-xs text-blue-600">
                <div class="bg-white rounded-lg p-2.5 border border-blue-100">
                    <p class="font-semibold">Admin</p>
                    <p class="text-blue-500 mt-0.5">admin@simplepos.test</p>
                    <p class="text-blue-400">password</p>
                </div>
                <div class="bg-white rounded-lg p-2.5 border border-blue-100">
                    <p class="font-semibold">Cajero</p>
                    <p class="text-blue-500 mt-0.5">cajero@simplepos.test</p>
                    <p class="text-blue-400">password</p>
                </div>
            </div>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-8">SimplePOS &copy; {{ date('Y') }} &mdash; Open Source</p>
</x-layouts.guest>
