<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Punto de Venta - SimplePOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 h-screen overflow-hidden" x-data="pos()">
    <div class="flex h-screen">
        {{-- Left: Products --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top bar --}}
            <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 font-bold text-lg">SimplePOS</a>
                    <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500" x-text="currentTime"></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 text-sm">Salir</button>
                    </form>
                </div>
            </div>

            {{-- Search + Categories --}}
            <div class="bg-white border-b border-gray-200 px-4 py-3">
                <input type="text" x-model="search" placeholder="Buscar producto o escanear código..."
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-3"
                    x-ref="searchInput" @keydown.enter.prevent="addByBarcode()">
                <div class="flex gap-2 overflow-x-auto pb-1">
                    <button @click="selectedCategory = null"
                        :class="selectedCategory === null ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors">
                        Todos
                    </button>
                    @foreach($categories as $cat)
                    <button @click="selectedCategory = selectedCategory === {{ $cat->id }} ? null : {{ $cat->id }}"
                        :class="selectedCategory === {{ $cat->id }} ? 'text-white' : 'text-gray-700 hover:bg-gray-200'"
                        :style="selectedCategory === {{ $cat->id }} ? 'background-color: {{ $cat->color }}' : 'background-color: #f3f4f6'"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors">
                        {{ $cat->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Product grid --}}
            <div class="flex-1 overflow-y-auto p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <button @click="product.stock > 0 && addToCart(product)"
                            :class="product.stock <= 0 ? 'opacity-50 cursor-not-allowed grayscale' : 'hover:border-blue-300 hover:shadow-sm active:scale-95'"
                            class="bg-white rounded-xl border border-gray-200 p-3 text-left transition-all relative">
                            <div x-show="product.stock <= 0" class="absolute inset-0 bg-white/60 rounded-xl z-10 flex items-center justify-center">
                                <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-lg">Agotado</span>
                            </div>
                            <div class="w-full h-20 bg-gray-100 rounded-lg mb-2 flex items-center justify-center overflow-hidden">
                                <template x-if="product.image">
                                    <img :src="product.image" class="w-full h-full object-cover rounded-lg">
                                </template>
                                <template x-if="!product.image">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </template>
                            </div>
                            <p class="text-xs font-medium text-gray-800 truncate" x-text="product.name"></p>
                            <p class="text-sm font-bold text-blue-600" x-text="'$' + product.price.toFixed(2)"></p>
                            <p class="text-xs" :class="product.stock <= 0 ? 'text-red-500 font-semibold' : (product.stock <= 5 ? 'text-amber-500' : 'text-gray-400')" x-text="product.stock + ' disp.'"></p>
                        </button>
                    </template>
                </div>
                <p x-show="filteredProducts.length === 0" class="text-center text-gray-500 py-10 text-sm">
                    No se encontraron productos.
                </p>
            </div>
        </div>

        {{-- Right: Cart --}}
        <div class="w-96 bg-white border-l border-gray-200 flex flex-col hidden lg:flex">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="font-semibold text-gray-800">Carrito</h2>
                <p class="text-xs text-gray-400" x-text="cart.length + ' producto(s)'"></p>
            </div>

            {{-- Cart items --}}
            <div class="flex-1 overflow-y-auto">
                <template x-if="cart.length === 0">
                    <div class="flex flex-col items-center justify-center h-full text-gray-400">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <p class="text-sm">Carrito vacío</p>
                    </div>
                </template>
                <template x-for="(item, index) in cart" :key="item.product_id">
                    <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate" x-text="item.name"></p>
                                <p class="text-xs text-gray-500" x-text="'$' + item.price.toFixed(2) + ' c/u'"></p>
                            </div>
                            <button @click="removeFromCart(index)" class="text-gray-400 hover:text-red-500 ml-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-2">
                                <button @click="updateQuantity(index, -1)" class="w-7 h-7 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center justify-center text-sm font-bold">-</button>
                                <span class="text-sm font-semibold w-8 text-center" x-text="item.quantity"></span>
                                <button @click="updateQuantity(index, 1)" class="w-7 h-7 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center justify-center text-sm font-bold">+</button>
                            </div>
                            <p class="text-sm font-bold text-gray-800" x-text="'$' + (item.price * item.quantity).toFixed(2)"></p>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Totals --}}
            <div class="border-t border-gray-200 p-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span x-text="'$' + subtotal.toFixed(2)"></span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600" x-show="discountValue > 0">
                    <span>Descuento</span>
                    <span class="text-red-600" x-text="'-$' + discountValue.toFixed(2)"></span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-800 pt-2 border-t border-gray-100">
                    <span>Total</span>
                    <span x-text="'$' + total.toFixed(2)"></span>
                </div>

                {{-- Discount toggle --}}
                <div class="pt-2">
                    <button @click="showDiscount = !showDiscount" class="text-xs text-blue-600 hover:underline">
                        <span x-text="showDiscount ? 'Ocultar descuento' : 'Aplicar descuento'"></span>
                    </button>
                    <div x-show="showDiscount" x-transition class="mt-2 flex gap-2">
                        <select x-model="discountType" class="px-2 py-1.5 border border-gray-300 rounded-lg text-xs">
                            <option value="fixed">$ Fijo</option>
                            <option value="percentage">% Porcentaje</option>
                        </select>
                        <input type="number" x-model.number="discountAmount" min="0" step="0.01" placeholder="0.00"
                            class="flex-1 px-2 py-1.5 border border-gray-300 rounded-lg text-xs">
                    </div>
                </div>

                <button @click="openPayment()" :disabled="cart.length === 0"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors mt-2">
                    COBRAR $<span x-text="total.toFixed(2)"></span>
                </button>
            </div>
        </div>

        {{-- Mobile cart button --}}
        <div class="lg:hidden fixed bottom-4 right-4 z-40">
            <button @click="mobileCart = true" class="bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <span x-show="cart.length > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center" x-text="cart.length"></span>
            </button>
        </div>
    </div>

    {{-- Payment modal --}}
    <div x-show="paymentModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/60 z-50 flex items-center justify-center p-4" @keydown.escape.window="paymentModal = false">
        <div class="bg-white rounded-2xl max-w-md w-full p-6" @click.stop>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Cobrar venta</h3>

            <div class="bg-blue-50 rounded-xl p-4 mb-4 text-center">
                <p class="text-sm text-blue-600">Total a cobrar</p>
                <p class="text-3xl font-bold text-blue-700" x-text="'$' + total.toFixed(2)"></p>
            </div>

            {{-- Payment method --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Método de pago</label>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                        class="border-2 rounded-lg py-2 text-sm font-medium transition-colors">Efectivo</button>
                    <button @click="paymentMethod = 'card'" :class="paymentMethod === 'card' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                        class="border-2 rounded-lg py-2 text-sm font-medium transition-colors">Tarjeta</button>
                    <button @click="paymentMethod = 'transfer'" :class="paymentMethod === 'transfer' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                        class="border-2 rounded-lg py-2 text-sm font-medium transition-colors">Transfer.</button>
                </div>
            </div>

            {{-- Amount paid (cash only) --}}
            <div x-show="paymentMethod === 'cash'" class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Monto recibido</label>
                <input type="number" x-model.number="amountPaid" step="0.01" min="0"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg font-semibold"
                    x-ref="amountInput">
                <div class="flex gap-2 mt-2">
                    <button @click="amountPaid = total" class="flex-1 bg-gray-100 text-gray-700 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-200">Exacto</button>
                    <button @click="amountPaid = Math.ceil(total)" class="flex-1 bg-gray-100 text-gray-700 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-200" x-text="'$' + Math.ceil(total)"></button>
                    <button @click="amountPaid = 5" class="flex-1 bg-gray-100 text-gray-700 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-200">$5</button>
                    <button @click="amountPaid = 10" class="flex-1 bg-gray-100 text-gray-700 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-200">$10</button>
                    <button @click="amountPaid = 20" class="flex-1 bg-gray-100 text-gray-700 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-200">$20</button>
                </div>

                <div x-show="amountPaid >= total && amountPaid > 0" class="mt-3 bg-green-50 rounded-lg p-3 text-center">
                    <p class="text-sm text-green-600">Cambio</p>
                    <p class="text-2xl font-bold text-green-700" x-text="'$' + (amountPaid - total).toFixed(2)"></p>
                </div>
            </div>

            {{-- Error message --}}
            <div x-show="saleError" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-lg text-sm" x-text="saleError"></div>

            <div class="flex gap-3">
                <button @click="confirmSale()" :disabled="processing || !canConfirm"
                    class="flex-1 bg-green-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors">
                    <span x-show="!processing">Confirmar Venta</span>
                    <span x-show="processing">Procesando...</span>
                </button>
                <button @click="paymentModal = false" class="px-4 py-3 text-gray-500 hover:text-gray-700 text-sm">Cancelar</button>
            </div>
        </div>
    </div>

    {{-- Success modal --}}
    <div x-show="successModal" x-transition class="fixed inset-0 bg-gray-900/60 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-1">Venta exitosa</h3>
            <p class="text-sm text-gray-500 mb-1" x-text="'No. ' + lastSaleNumber"></p>
            <p class="text-2xl font-bold text-green-600 mb-4" x-text="'$' + lastSaleTotal.toFixed(2)"></p>
            <div x-show="lastSaleChange > 0" class="bg-yellow-50 rounded-lg p-3 mb-4">
                <p class="text-sm text-yellow-700">Cambio: <strong x-text="'$' + lastSaleChange.toFixed(2)"></strong></p>
            </div>
            <div class="flex gap-2">
                <a :href="'/ventas/' + lastSaleId + '/recibo'" target="_blank" class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Imprimir Recibo</a>
                <button @click="closeSuccess()" class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-200">Nueva Venta</button>
            </div>
        </div>
    </div>

    <script>
    function pos() {
        return {
            products: @json($products),
            cart: [],
            search: '',
            selectedCategory: null,
            showDiscount: false,
            discountType: 'fixed',
            discountAmount: 0,
            paymentModal: false,
            paymentMethod: 'cash',
            amountPaid: 0,
            processing: false,
            saleError: '',
            successModal: false,
            lastSaleId: null,
            lastSaleNumber: '',
            lastSaleTotal: 0,
            lastSaleChange: 0,
            mobileCart: false,
            currentTime: '',

            init() {
                this.updateTime();
                setInterval(() => this.updateTime(), 60000);
                this.$refs.searchInput?.focus();
            },

            updateTime() {
                this.currentTime = new Date().toLocaleString('es-SV', { hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit', year: 'numeric' });
            },

            get filteredProducts() {
                return this.products.filter(p => {
                    const matchSearch = !this.search ||
                        p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        (p.barcode && p.barcode.includes(this.search));
                    const matchCategory = !this.selectedCategory || p.category_id === this.selectedCategory;
                    return matchSearch && matchCategory;
                });
            },

            get subtotal() {
                return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            get discountValue() {
                if (!this.discountAmount || this.discountAmount <= 0) return 0;
                return this.discountType === 'percentage'
                    ? this.subtotal * (this.discountAmount / 100)
                    : this.discountAmount;
            },

            get total() {
                return Math.max(0, this.subtotal - this.discountValue);
            },

            get canConfirm() {
                if (this.paymentMethod === 'cash') return this.amountPaid >= this.total;
                return true;
            },

            addToCart(product) {
                const existing = this.cart.find(item => item.product_id === product.id);
                if (existing) {
                    if (existing.quantity < product.stock) {
                        existing.quantity++;
                    }
                } else {
                    this.cart.push({
                        product_id: product.id,
                        name: product.name,
                        price: product.price,
                        quantity: 1,
                        max_stock: product.stock,
                    });
                }
            },

            addByBarcode() {
                if (!this.search) return;
                const product = this.products.find(p => p.barcode === this.search);
                if (product) {
                    this.addToCart(product);
                    this.search = '';
                }
            },

            updateQuantity(index, delta) {
                const item = this.cart[index];
                const newQty = item.quantity + delta;
                if (newQty < 1) {
                    this.removeFromCart(index);
                } else if (newQty <= item.max_stock) {
                    item.quantity = newQty;
                }
            },

            removeFromCart(index) {
                this.cart.splice(index, 1);
            },

            openPayment() {
                if (this.cart.length === 0) return;
                this.paymentMethod = 'cash';
                this.amountPaid = 0;
                this.saleError = '';
                this.paymentModal = true;
                this.$nextTick(() => {
                    if (this.$refs.amountInput) this.$refs.amountInput.focus();
                });
            },

            async confirmSale() {
                if (this.processing) return;
                this.processing = true;
                this.saleError = '';

                if (this.paymentMethod !== 'cash') {
                    this.amountPaid = this.total;
                }

                try {
                    const response = await fetch('{{ route("pos.sale") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            items: this.cart.map(i => ({ product_id: i.product_id, quantity: i.quantity })),
                            payment_method: this.paymentMethod,
                            amount_paid: this.amountPaid,
                            discount_amount: this.discountAmount || 0,
                            discount_type: this.discountType,
                        }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.lastSaleId = data.sale_id;
                        this.lastSaleNumber = data.sale_number;
                        this.lastSaleTotal = data.total;
                        this.lastSaleChange = data.change;
                        this.paymentModal = false;
                        this.successModal = true;
                    } else {
                        this.saleError = data.message || 'Error al procesar la venta.';
                    }
                } catch (e) {
                    this.saleError = 'Error de conexión. Intente de nuevo.';
                } finally {
                    this.processing = false;
                }
            },

            closeSuccess() {
                this.successModal = false;

                // Update stock locally based on what was just sold
                this.cart.forEach(item => {
                    const product = this.products.find(p => p.id === item.product_id);
                    if (product) {
                        product.stock = Math.max(0, product.stock - item.quantity);
                    }
                });


                this.cart = [];
                this.discountAmount = 0;
                this.showDiscount = false;
                this.search = '';
                this.$refs.searchInput?.focus();
            },
        };
    }
    </script>
</body>
</html>
