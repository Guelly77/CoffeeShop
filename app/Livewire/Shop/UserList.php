<?php

namespace App\Livewire\Shop;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public function render()
    {
        return view('livewire.shop.user-list', [
            'users' => User::all(),
        ]);
    }
}
