<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Danish routes (default)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kontakt', [ContactController::class, 'show'])->name('contact');
Route::get('/afdelinger/{slug}', [DepartmentController::class, 'show'])->name('department.show');
Route::get('/nyheder', [NewsController::class, 'index'])->name('news.index');
Route::get('/nyheder/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/side/{slug}', [PageController::class, 'show'])->name('page.show');

// English routes
Route::prefix('en')->name('en.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
    Route::get('/departments/{slug}', [DepartmentController::class, 'show'])->name('department.show');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
    Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
});
