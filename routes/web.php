<?php

use App\Drone\Drone;
use App\Http\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return Drone::builds('mackensiealvarezz', 'custom-ci');
});
Route::get('/home', HomePage::class);
