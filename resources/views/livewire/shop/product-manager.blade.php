<div>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="mx-auto max-w-6xl">
            <h1 class="mb-6 text-3xl font-bold">
                Product Management
            </h1>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-xl bg-white p-5 shadow">
                    <h2 class="mb04 text-xl font-semibold">Add Product</h2>
                    
                    <div class="space-y-4">
                        <input wire:model="name" type="text" placeholder="Product Name" class="w-full rounded-lg border p-3">
                        <select wire:model="category" class="w-full rounded-lg border p-3">
                            <option>Coffee</option>
                            <option>Cold Drink</option>
                            <option value="">Non-Coffee</option>
                            <option value="">Pastry</option>
                        </select>
                        <input wire:model="price" type="number" step="0.1" placeholder="Price" class="w-full rounded-lg border p-3">
                        <input wire:model="image" type="file" class="w-full rounded-lg border p-3">
                        <button wire:click="saveProduct" class="w-full rounded-lg bg-green-600 py-3 hover:bg-green-700 hover:cursor-pointer">
                            Save Product
                        </button>
                    </div>
                </div>

                {{-- Product List --}}
                <div class="lg:col-span-2 rounded-xl bg-white p-5 shadow">

                    <h2 class="mb-4 text-xl font-semibold">
                        Items Available on the Menu
                    </h2>

                    <div class="space-y-3">

                        @foreach ($products as $product)

                            <div class="flex items-center justify-between rounded-lg border p-3">

                                <div class="flex items-center gap-3">

                                    @if($product->image)

                                        <img
                                            src="{{ asset('storage/'.$product->image) }}"
                                            class="h-14 w-14 rounded-lg object-cover"
                                        >

                                    @else

                                        <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-gray-200 text-2xl">
                                            ☕
                                        </div>

                                    @endif

                                    <div>

                                        <h3 class="font-semibold">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            {{ $product->category }}
                                        </p>

                                    </div>

                                </div>

                                <span class="font-bold text-green-600">
                                    ₱{{ number_format($product->price,2) }}
                                </span>

                                <div>
                                    <button wire:click="delete({{ $product->id }})" class="text-red-500 hover:text-red-700 border rounded-lg px-3 py-1 hover:cursor-pointer">
                                        Delete
                                    </button>
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
