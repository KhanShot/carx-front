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
Route::post('/form/submit/resend', [\App\Http\Controllers\FormController::class, 'resend'])->name('form.resend');
Route::post('/form/change-number', [\App\Http\Controllers\FormController::class, 'changeNumber'])->name('form.changeNumber');
Route::get('/form/verify', [\App\Http\Controllers\FormController::class, 'verify'])->name('form.verify');
Route::post('/form/phone/verify', [\App\Http\Controllers\FormController::class, 'phoneVerify'])->name('form.phone.verify');

Route::get('/test-event', function (){
    $user = \App\Models\User::query()->find(4);
    $row['test'] = '1';
    $row['test2'] = '2';
    $row['test3'] = '3';
    $row['test4'] = '34563';
    broadcast(new \App\Events\FormCreatedEvent($row, $user));
    return 'succeed';
});

Route::get('test', function (){
    event(new \App\Events\Hello());
    return 'event sent';

});
