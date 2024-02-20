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
    return view('pages.main');
});

Route::get('/form', function () {
    return view('pages.form');
})->name('form');

Route::post('/form/submit', [\App\Http\Controllers\FormController::class, 'store'])->name('form.submit');
Route::get('/form/verify', [\App\Http\Controllers\FormController::class, 'verify'])->name('form.verify');
Route::post('/form/phone/verify', [\App\Http\Controllers\FormController::class, 'phoneVerify'])->name('form.phone.verify');
