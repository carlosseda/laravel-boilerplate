<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['name' => 'Amigo']);
});

Route::get('/tienda/{producto}', function (string $producto) {
  return view('shop', ['name' => $producto]);
});

Route::get('/quienes-somos', function () {
  return view('welcome', ['name' => 'Carlos']);
});

Route::get('/contacto', function () {
  return view('welcome', ['name' => 'Carlos']);
});

