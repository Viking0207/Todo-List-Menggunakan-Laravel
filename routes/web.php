<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\todoController;
use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
// Route::get('/', function () {
//      return view('home');
// });

Route::get('/', [todoController::class, 'index'])->name('home.index');
=======
// Route::get('/k', function () {
//      return view('first');
// });

Route::get('/database', [todoController::class, 'index'])->name('home.index');

Route::get('/', [todoController::class, 'show'])->name('first.index');

>>>>>>> b082ddd (File Sebelumnya yang harusnya nanti di upgrade.)
Route::get('/todo/add', [todoController::class, 'create'])->name('add.create');

Route::post('/todo/save', [todoController::class, 'simpan'])->name('add.simpan');

Route::put('/todo/update/{id}', [todoController::class, 'update'])->name('home.update');
// Route::patch('/todo-status/{id}', [todoController::class, 'updateStat'])->name('status.update');

Route::delete('/todo/{id}', [todoController::class, 'delete'])->name('home.delete');
