<?php

use App\Livewire\Shop\CoffeeShop;
use App\Livewire\Shop\ProductManager;
use App\Livewire\Shop\UserList;
use Illuminate\Support\Facades\Route;

Route::get('/', CoffeeShop::class);
Route::get('/products', ProductManager::class);
Route::get('/users', UserList::class);