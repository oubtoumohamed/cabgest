<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/caisse/'], function () {

        Route::get('list', [App\Http\Controllers\CaisseController::class, 'index'])
            ->name('caisse')
            ->middleware('Admin:CAISSE_LIST');

        Route::get('ajaxlist', [App\Http\Controllers\CaisseController::class, 'ajaxlist'])
            ->name('caisse_ajaxlist');
        
        Route::get('create', [App\Http\Controllers\CaisseController::class, 'create'])
            ->name('caisse_create')
            ->middleware('Admin:CAISSE_CREATE');
        
        Route::post('create', [App\Http\Controllers\CaisseController::class, 'store'])
            ->name('caisse_store')
            ->middleware('Admin:CAISSE_CREATE');
        
        Route::get('{id}', [App\Http\Controllers\CaisseController::class, 'show'])
            ->name('caisse_show')
            ->middleware('Admin:CAISSE_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\CaisseController::class, 'edit'])
            ->name('caisse_edit')
            ->middleware('Admin:CAISSE_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}', [App\Http\Controllers\CaisseController::class, 'update'])
            ->name('caisse_update')
            ->middleware('Admin:CAISSE_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\CaisseController::class, 'destroy'])
            ->name('caisse_delete')
            ->middleware('Admin:CAISSE_DELETE')
            ->where('id', '[0-9]+');
    });
});