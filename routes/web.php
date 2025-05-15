<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\todoController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

// Route::get('/k', function () {
//      return view('first');
// });

Route::get('/', [todoController::class, 'show'])->name('dashboard.index');

Route::get('/database', [todoController::class, 'index'])->name('home.index');

Route::get('/todo/add', [todoController::class, 'create'])->name('add.create');

Route::post('/todo/save', [todoController::class, 'simpan'])->name('add.simpan');

Route::put('/todo/update/{id}', [todoController::class, 'update'])->name('home.update');
// Route::patch('/todo-status/{id}', [todoController::class, 'updateStat'])->name('status.update');

Route::delete('/todo/{id}', [todoController::class, 'delete'])->name('home.delete');


// Register
Route::get('/register', [userController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [userController::class, 'register'])->name('register.store');

// Login
Route::get('/login', [userController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [userController::class, 'login'])->name('login.do');

// Logout
Route::post('/logout', [userController::class, 'logout'])->name('logout');
