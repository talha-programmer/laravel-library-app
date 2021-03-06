<?php

use App\Http\Controllers\Library\BookController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/form', [BookController::class, 'form'])->name('books.form');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    
    Route::post('/books/checkin/{book}', [BookController::class, 'checkin'])->name('books.checkin');
    Route::post('/books/checkout/{book}', [BookController::class, 'checkout'])->name('books.checkout');
});

require __DIR__.'/auth.php';
