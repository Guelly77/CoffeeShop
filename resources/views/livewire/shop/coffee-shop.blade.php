<div>
    <div class="min-h-screen bg-gray-100 p-6">

        <div class="mx-auto max-w-7xl">

            <div class="mb-6">
                <h1 class="text-3xl font-bold">
                    ☕ Coffee Shop POS
                </h1>

                <p class="text-gray-500">
                    Select a product to add it to the cart.
                </p>
            </div>

            <div class="flex mb-5 gap-2 overflow-x-auto">
                <button
                    wire:click="$set('selectedCategory', 'All')"
                    class="rounded-lg px-4 py-2 font-medium"
                    {{
                        $selectedCategory === 'All'
                        ? 'bg-green-600 text-white'
                        : 'bg-gray-200 text-gray-700'
                    }}
                >
                    All
                </button>

                @foreach ($categories as $category)
                    <button
                        wire:click="$set('selectedCategory', '{{ $category}}')"
                        class="rounded-lg px-4 py-2 font-medium whitespace-nowrap"
                        {{
                            $selectedCategory === $category
                            ? 'bg-green-600 text-white'
                            : 'bg-gray-200 text-gray-700'
                        }}
                    >
                        {{ $category }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- PRODUCTS --}}
                <div class="lg:col-span-2">

                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">

                        @foreach ($products as $product)

                            <button
                                wire:click="addToCart({{ $product->id }})"
                                class="rounded-xl bg-white p-4 text-left shadow transition hover:scale-105 hover:shadow-lg"
                            >

                                <div class="mb-4 flex h-32 items-center justify-center rounded-lg bg-gray-100 text-5xl">
                                    ☕
                                </div>

                                <h2 class="font-semibold">
                                    {{ $product->name }}
                                </h2>

                                <p class="mt-1 text-lg font-bold text-green-600">
                                    ₱{{ number_format($product->price, 2) }}
                                </p>

                            </button>

                        @endforeach

                    </div>

                </div>


                {{-- CART --}}
                <div class="rounded-xl bg-white p-5 shadow">

                    <div class="mb-4 flex items-center justify-between">

                        <h2 class="text-xl font-bold">
                            🛒 Current Order
                        </h2>

                        @if(count($cart) > 0)
                            <button
                                wire:click="clearCart"
                                class="text-sm text-red-500 hover:underline"
                            >
                                Clear
                            </button>
                        @endif

                    </div>


                    {{-- EMPTY CART --}}
                    @if(count($cart) === 0)

                        <div class="py-16 text-center text-gray-400">

                            <div class="mb-3 text-5xl">
                                🛒
                            </div>

                            <p>
                                No items in cart
                            </p>

                        </div>

                    @else

                        {{-- CART ITEMS --}}
                        <div class="space-y-4">

                            @foreach ($cart as $item)

                                <div class="flex items-center justify-between">

                                    <div>

                                        <h3 class="font-semibold">
                                            {{ $item['name'] }}
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            ₱{{ number_format($item['price'], 2) }}
                                        </p>

                                    </div>


                                    <div class="flex items-center gap-2">

                                        <button
                                            wire:click="decreaseQuantity({{ $item['id'] }})"
                                            class="flex h-7 w-7 items-center justify-center rounded bg-gray-200"
                                        >
                                            −
                                        </button>

                                        <span class="w-6 text-center">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <button
                                            wire:click="increaseQuantity({{ $item['id'] }})"
                                            class="flex h-7 w-7 items-center justify-center rounded bg-gray-200"
                                        >
                                            +
                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- TOTAL --}}
                        <div class="mt-6 border-t pt-4">

                            <div class="mb-4 flex justify-between text-lg font-bold">

                                <span>
                                    Total
                                </span>

                                <span>
                                    ₱{{ number_format($this->subtotal, 2) }}
                                </span>

                            </div>


                            <button
                                class="w-full rounded-lg bg-green-600 py-3 font-semibold text-white transition hover:bg-green-700"
                            >
                                CHECKOUT
                            </button>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>
</div>
