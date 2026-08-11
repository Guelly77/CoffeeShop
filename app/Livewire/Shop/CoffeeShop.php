<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Products;
use Livewire\Attributes\Title;

class CoffeeShop extends Component
{
    #[Title('POS')]

    public $cart = [];
    
    public $selectedCategory = 'All';

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
