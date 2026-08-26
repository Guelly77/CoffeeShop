<?php

namespace App\Livewire\Shop;

use App\Models\Products;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductManager extends Component
{
    use WithFileUploads;

    public $name = '';
    public $category = 'Coffee';
    public $price = '';
    public $image;

    protected $rules = [
        'name' => 'required|min:2',
        'category' => 'required',
        'price' => 'required|numeric|min:1',
        'image' => 'nullable|image|max:2048',
    ];

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
            'image' => $this->image,
            'is_available' => true,
        ]);

        $this->reset(['name', 'price', 'image']);
        $this->category = 'Coffee';

        session()->flash('success', 'Product added successfully');
    }

    public function render()
    {
        return view('livewire.shop.product-manager', [
            'products' => Products::latest()->get()
        ]);
    }
}
