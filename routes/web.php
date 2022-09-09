<?php

use App\Http\Controllers\Auth\{
    RegisterController,
    LoginController
};

use App\Http\Controllers\User\{
    IndexController,
    Meet\MeetController
};
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'auth.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('register', [RegisterController::class, 'create'])->name('register.create');
        Route::post('register', [RegisterController::class, 'store'])->name('register.store');
        Route::get('login', [LoginController::class, 'create'])->name('login.create');
        Route::post('login', [LoginController::class, 'store'])->name('login.store');
    });
    Route::post('logout', [LoginController::class, 'destroy'])
        ->name('login.destroy')
        ->middleware(['auth']);
});

Route::group(['middleware' => 'auth', 'prefix' => 'user', 'as' => 'user.meets.'], function () {

    Route::get('meets', [MeetController::class, 'index'])
        ->name('index');
    Route::get('meets/create', [MeetController::class, 'create'])
        ->name('create');
    Route::post('meets', [MeetController::class, 'store'])
        ->name('store');    

    Route::get('{id}/horarios', [MeetController::class, 'index_horarios'])
        ->name('meet');
    Route::get('{id}/horario/create', [MeetController::class, 'create_horario'])
        ->name('meet.create');
    Route::post('{id}/horario/store', [MeetController::class, 'store_horario'])
        ->name('meet.store');
});


