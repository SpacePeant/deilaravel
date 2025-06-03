<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/home', 'home')->name('home');
Route::view('/biodata', 'biodata')->name('biodata');


Route::get('/anak', [AnakController::class, 'index'])->name('anak');


Route::get('/anak/detail/{id}', [AnakController::class, 'show'])->name('anak.show');
Route::post('/anak/delete/{id}', [AnakController::class, 'destroy'])->name('anak.destroy');
Route::post('/anak', [AnakController::class, 'store'])->name('anak.store');




// Menu page
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

// Pilihanak (Order) page
Route::get('/pilihanak', function () {
    return view('pilihanak');
})->name('pilihanak');

// Order Details page
Route::get('/order_details', function () {return view('order_details');})->name('order_details');

Route::get('/Energi-Pagi', [MenuController::class, 'showEnergiPagi']);
Route::get('/Lunch-Hero', [MenuController::class, 'showLunchHero']); // New route
Route::get('/Jajan-sehat', [MenuController::class, 'showJajanSehat']); // New route
Route::get('/Happy-Tummy', [MenuController::class, 'showHappyTummy']); // New route
Route::get('/Nusantara-Mini', [MenuController::class, 'showNusantaraMini']); // New route
Route::get('/Western-Fun', [MenuController::class, 'showWesternFun']); // New route
Route::get('/Plant-Power', [MenuController::class, 'showPlantPower']); // New route


Route::get('/add', [AnakController::class, 'add'])->name('add');

Route::get('/pilihanak', [AnakController::class, 'pilih'])->name('anak.pilih');

Route::get('/menu-order', [MenuController::class, 'index'])->name('order');

Route::get('/order', [OrderController::class, 'index'])->name('order.show');


Route::get('/filterMenu', function () { return view('get_cart'); })->name('filterMenu');

Route::get('/menu/{categoryName}', [MenuController::class, 'showCategoryMenus'])->name('menu.category');