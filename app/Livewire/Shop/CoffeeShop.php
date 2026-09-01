<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Products;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;

class CoffeeShop extends Component
{
    #[Title('Products')]

    public $cart = [];
    
    public $selectedCategory = 'All';

    public $paymentMethod = 'Cash';
    public $amountReceived = 0;

    public function addToCart($productId)
    {
        $product = Products::findOrFail($productId);

        if(isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,    
            ];
        }
    }

    public function increaseQuantity($productId)
    {
        if(isset($this->cart[$productId])){
            $this->cart[$productId]['quantity']++;
        }
    }

    public function decreaseQuantity($productId)
    {
        if(isset($this->cart[$productId])){
            $this->cart[$productId]['quantity']--;

            if($this->cart[$productId]['quantity'] <= 0 ){
                unset($this->cart[$productId]);
            }
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function clearCart()
    {
        $this->cart = [];
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function checkout()
    {
        if (count($this->cart) === 0) {
            session()->flash('error', 'Cart is empty.');
            return;
        }

        DB::transaction(function () {

            $order = Order::create([
                'order_number' => 'ORD-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
                'subtotal' => $this->subtotal,
                'tax' => 0,
                'discount' => 0,
                'total' => $this->subtotal,
                'payment_method' => $this->paymentMethod,
                'amount_received' => $this->amountReceived ?: $this->subtotal,
                'change' => max(0, ($this->amountReceived ?: $this->subtotal) - $this->subtotal),
                'status' => 'Completed',
            ]);

            foreach ($this->cart as $item) {

                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }
        });

        $this->clearCart();

        session()->flash('success', 'Order completed successfully!');
    }

    public function render()
    {
        $query = Products::where('is_available', true);

        if($this->selectedCategory !== 'All') {
            $query->where('category', $this->selectedCategory);
        }

        return view('livewire.shop.coffee-shop', [
            'products' => $query->get(),
            'categories' => Products::where('is_available', true)
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category'),
        ]);
    }
}
