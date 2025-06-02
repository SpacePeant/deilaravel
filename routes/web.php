<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnakController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/home', 'home')->name('home');
Route::view('/biodata', 'biodata')->name('biodata');

// Anak page
Route::get('/anak', [AnakController::class, 'index']);


// Menu page
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

// Pilihanak (Order) page
Route::get('/pilihanak', function () {
    return view('pilihanak');
})->name('pilihanak');

// Order Details page
Route::get('/order_details', function () {
    return view('order_details');
})->name('order_details');

Route::view('/Energi-Pagi', 'categories.Energi-Pagi');
Route::view('/Lunch-Hero', 'categories.Lunch-Hero');
Route::view('/Jajan-sehat', 'categories.Jajan-sehat');
Route::view('/Happy-Tummy', 'categories.Happy-Tummy');
Route::view('/Nusantara-Mini', 'categories.Nusantara-Mini');
Route::view('/Western-Fun', 'categories.Western-Fun');
Route::view('/Plant-Power', 'categories.Plant-Power');

