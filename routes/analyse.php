<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/analyse/'], function () {

        Route::get('list', [App\Http\Controllers\AnalyseController::class, 'index' ])
            ->name('analyse')
            ->middleware('Admin:ANALYSE_LIST');

        Route::get('ajaxlist', [App\Http\Controllers\AnalyseController::class, 'ajaxlist' ])
            ->name('analyse_ajaxlist');
        
        Route::get('create', [App\Http\Controllers\AnalyseController::class, 'create' ])
            ->name('analyse_create')
            ->middleware('Admin:ANALYSE_CREATE');
        
        Route::post('create', [App\Http\Controllers\AnalyseController::class, 'store' ])
            ->name('analyse_store')
            ->middleware('Admin:ANALYSE_CREATE');
        
        Route::get('{id}/show', [App\Http\Controllers\AnalyseController::class, 'show' ])
            ->name('analyse_show')
            ->middleware('Admin:ANALYSE_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\AnalyseController::class, 'edit' ])
            ->name('analyse_edit')
            ->middleware('Admin:ANALYSE_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}/update', [App\Http\Controllers\AnalyseController::class, 'update' ])
            ->name('analyse_update')
            ->middleware('Admin:ANALYSE_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\AnalyseController::class, 'destroy' ])
            ->name('analyse_delete')
            ->middleware('Admin:ANALYSE_DELETE')
            ->where('id', '[0-9]+');
    });
});
