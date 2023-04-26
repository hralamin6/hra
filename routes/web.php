<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

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
Route::get('/', \App\Http\Livewire\HomeComponent::class)->name('home');
Route::get('pdf', [\App\Http\Controllers\PdfController::class, 'index'])->name('pdf');
Route::get('invoice/pdf/{slug:id}', [\App\Http\Controllers\PdfController::class, 'invoice'])->name('pdf.invoice');
Route::get('purchase/pdf/{slug:id}', [\App\Http\Controllers\PdfController::class, 'purchase'])->name('pdf.purchase');
Route::get('/', \App\Http\Livewire\HomeComponent::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Livewire\DashboardComponent::class)->name('dashboard');
    Route::get('/chat', \App\Http\Livewire\ChatlistComponent::class)->name('chat');
    Route::get('/dashboard/users', \App\Http\Livewire\UserComponent::class)->name('users');
    Route::get('/dashboard/categories', \App\Http\Livewire\CategoryComponent::class)->name('categories');
    Route::get('/dashboard/brands', \App\Http\Livewire\BrandComponent::class)->name('brands');
    Route::get('/dashboard/groups', \App\Http\Livewire\GroupComponent::class)->name('groups');
    Route::get('/dashboard/units', \App\Http\Livewire\UnitComponent::class)->name('units');
    Route::get('/dashboard/products', \App\Http\Livewire\ProductComponent::class)->name('products');
    Route::get('/dashboard/purchases', \App\Http\Livewire\PurchaseComponent::class)->name('purchases');
    Route::get('/dashboard/invoices', \App\Http\Livewire\InvoiceComponent::class)->name('invoices');


    Route::get('/quiz', \App\Http\Livewire\Quiz\HomeComponent::class)->name('quiz.home');
});

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('auth/{provider}/redirect', [\App\Http\Controllers\SocialiteController::class, 'loginSocial'])->name('socialite.auth');
    Route::get('auth/{provider}/callback', [\App\Http\Controllers\SocialiteController::class, 'callbackSocial'])->name('socialite.callback');

});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});
