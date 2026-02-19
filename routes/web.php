<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/nyheder', [NewsController::class, 'index'])->name('news.index');
Route::get('/nyheder/{slug}', [NewsController::class, 'show'])->name('news.show');

// Departments
Route::get('/afdelinger', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/afdelinger/{slug}', [DepartmentController::class, 'show'])->name('departments.show');

// Registration
Route::get('/tilmeld', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/tilmeld', [RegistrationController::class, 'store'])->name('registration.store');

// Contact
Route::get('/kontakt', [ContactController::class, 'create'])->name('contact');
Route::post('/kontakt', [ContactController::class, 'store'])->name('contact.store');

// Static / content pages
Route::get('/om-klubben', [PageController::class, 'about'])->name('about');
Route::get('/vedtaegter', [PageController::class, 'vedtaegter'])->name('vedtaegter');
