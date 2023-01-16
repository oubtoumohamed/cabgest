<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/motif/'], function () {

        Route::get('list', [App\Http\Controllers\MotifController::class, 'index'])
            ->name('motif')
            ->middleware('Admin:MOTIF_LIST');

        Route::get('ajaxlist', [App\Http\Controllers\MotifController::class, 'ajaxlist'])
            ->name('motif_ajaxlist');
        
        Route::get('create', [App\Http\Controllers\MotifController::class, 'create'])
            ->name('motif_create')
            ->middleware('Admin:MOTIF_CREATE');
        
        Route::post('create', [App\Http\Controllers\MotifController::class, 'store'])
            ->name('motif_store')
            ->middleware('Admin:MOTIF_CREATE');
        
        Route::get('{id}', [App\Http\Controllers\MotifController::class, 'show'])
            ->name('motif_show')
            ->middleware('Admin:MOTIF_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\MotifController::class, 'edit'])
            ->name('motif_edit')
            ->middleware('Admin:MOTIF_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}', [App\Http\Controllers\MotifController::class, 'update'])
            ->name('motif_update')
            ->middleware('Admin:MOTIF_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\MotifController::class, 'destroy'])
            ->name('motif_delete')
            ->middleware('Admin:MOTIF_DELETE')
            ->where('id', '[0-9]+');
    });
});