<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/dossier/'], function () {

        Route::get('list', [App\Http\Controllers\DossierController::class, 'index' ])
            ->name('dossier')
            ->middleware('Admin:DOSSIER_LIST');

        Route::get('today', [App\Http\Controllers\DossierController::class, 'today' ])
            ->name('dossier_today')
            ->middleware('Admin:DOSSIER_LIST');
        
        Route::get('create', [App\Http\Controllers\DossierController::class, 'create' ])
            ->name('dossier_create')
            ->middleware('Admin:DOSSIER_CREATE');
        
        Route::post('create', [App\Http\Controllers\DossierController::class, 'store' ])
            ->name('dossier_store')
            ->middleware('Admin:DOSSIER_CREATE');
        
        Route::get('{id}/show', [App\Http\Controllers\DossierController::class, 'show' ])
            ->name('dossier_show')
            ->middleware('Admin:DOSSIER_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\DossierController::class, 'edit' ])
            ->name('dossier_edit')
            ->middleware('Admin:DOSSIER_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}/update', [App\Http\Controllers\DossierController::class, 'update' ])
            ->name('dossier_update')
            ->middleware('Admin:DOSSIER_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\DossierController::class, 'destroy' ])
            ->name('dossier_delete')
            ->middleware('Admin:DOSSIER_DELETE')
            ->where('id', '[0-9]+');
    });
});
