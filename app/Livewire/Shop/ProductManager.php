<?php

namespace App\Livewire\Shop;

use App\Models\Products;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductManager extends Component
{
    use WithFileUploads;

    #[Rule('required|min:2')]
    public $name = '';

    #[Rule('required')]
    public $category = 'Coffee';

    #[Rule('required|numeric|min:1')]
    public $price = '';

    #[Rule('nullable|image|max:2048')]
    public $image;

    public function saveProduct()
    {
        $this->validate();

        $imagePath = null;

        if($this->image){
            $imagePath = $this->image->store('products', 'public');
        }

        Products::create([
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price,
            'image' => $imagePath,
            'is_available' => true,
        ]);

        $this->reset(['name', 'price', 'image']);
        $this->category = 'Coffee';

        session()->flash('success', 'Product added successfully');
    }

    public function delete($productId)
    {
        $product = Products::findorFail($productId);
        $product->delete();

        session()->flash('success', 'Product deleted successfully');
    }

    public function render()
    {
        return view('livewire.shop.product-manager', [
            'products' => Products::latest()->get()
        ]);
    }
}
