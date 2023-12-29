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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('hotels', \App\Http\Controllers\HotelController::class);
    Route::controller(\App\Http\Controllers\RoomController::class)
        ->prefix('rooms')
        ->group(function () {
            Route::get('/{room}/edit', 'edit')->name('rooms.edit');
            Route::put('/{room}', 'update')->name('rooms.update');
            Route::delete('/{room}', 'destroy')->name('rooms.destroy');
        });
});

Route::get('/switch/{locale}', function ($locale) {
    $locale = str_replace('-', '_', $locale);
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

Route::get('/language/messages.js', function () {
    $locales = [];
    foreach (glob(base_path('lang/**')) as $localePath) {
        $exp = explode(DIRECTORY_SEPARATOR, $localePath);
        $locale = array_pop($exp);
        foreach (glob(base_path('lang/' . $locale) . "/*.php") as $filepath) {
            $exp = explode(DIRECTORY_SEPARATOR, $filepath);
            $filename = array_pop($exp);
            $content = require_once($filepath);
            $locales[str_replace('_', '-', $locale) . "." . substr($filename, 0, strlen($filename) - 4)] = $content;
        }
    }

    return response('const messages = ' . json_encode($locales, JSON_PRETTY_PRINT))
        ->header('Content-Type', 'text/javascript');
})->name('locale-js');
