<?php

use App\Http\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', HomePage::class);
