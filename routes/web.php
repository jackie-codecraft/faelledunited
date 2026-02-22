<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterPreviewController;
use App\Http\Controllers\MailingListController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/nyheder', [NewsController::class, 'index'])->name('news.index');
Route::get('/nyheder/{slug}', [NewsController::class, 'show'])->name('news.show');

// Departments
Route::get('/afdelinger', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/afdelinger/{department:slug}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('/afdelinger/{department:slug}/{ageGroup:slug}', [DepartmentController::class, 'showAgeGroup'])->name('departments.agegroups.show');

// Registration
Route::get('/tilmeld', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/tilmeld', [RegistrationController::class, 'store'])->name('registration.store');

// Contact
Route::get('/kontakt', [ContactController::class, 'create'])->name('contact');
Route::post('/kontakt', [ContactController::class, 'store'])->name('contact.store');

// Mailing list
Route::post('/mailing-list', [MailingListController::class, 'store'])->name('mailing-list.store');

// Unsubscribe
Route::get('/afmeld', [UnsubscribeController::class, 'confirm'])->name('unsubscribe.confirm');
Route::post('/afmeld', [UnsubscribeController::class, 'process'])->name('unsubscribe.process');

// Static / content pages
Route::get('/om-klubben', [PageController::class, 'about'])->name('about');
Route::get('/vedtaegter', [PageController::class, 'vedtaegter'])->name('vedtaegter');
Route::get('/privatlivspolitik', [PageController::class, 'privacyPolicy'])->name('privacy-policy');

// Language switcher
Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['da', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back()->withInput();
})->name('language.switch');

// Newsletter preview (admin-auth protected)
Route::get('/admin/newsletters/{newsletter}/preview', [NewsletterPreviewController::class, 'show'])
    ->name('newsletters.preview')
    ->middleware(['auth']);
