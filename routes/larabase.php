<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/larabase/creator'], function () {
        
        Route::get('/', [App\Http\Controllers\LarabaseController::class, 'create' ])
            ->name('creator_create')
            ->middleware('Admin:ADMIN');
        
        Route::post('/create', [App\Http\Controllers\LarabaseController::class, 'store' ])
            ->name('creator_store')
            ->middleware('Admin:ADMIN');
    });

    Route::group(['middleware' => 'auth','prefix' => '/admin/larabase/translator'], function () {
        
        Route::get('/{lang?}/{module?}', [App\Http\Controllers\LarabaseController::class, 'translator_create' ])
            ->name('translator_create')
            ->middleware('Admin:ADMIN');
        
        Route::post('/create', [App\Http\Controllers\LarabaseController::class, 'translator_store' ])
            ->name('translator_store')
            ->middleware('Admin:ADMIN');
    });
});