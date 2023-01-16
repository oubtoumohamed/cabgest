<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth', 'prefix' => '/admin/medicament/'], function () {

        Route::get('list', [App\Http\Controllers\MedicamentController::class, 'index'])
            ->name('medicament')
            ->middleware('Admin:MEDICAMENT_LIST');

        Route::get('ajaxlist', [App\Http\Controllers\MedicamentController::class, 'ajaxlist'])
            ->name('medicament_ajaxlist');
        
        Route::get('create', [App\Http\Controllers\MedicamentController::class, 'create'])
            ->name('medicament_create')
            ->middleware('Admin:MEDICAMENT_CREATE');
        
        Route::post('create', [App\Http\Controllers\MedicamentController::class, 'store'])
            ->name('medicament_store')
            ->middleware('Admin:MEDICAMENT_CREATE');
        
        Route::get('{id}', [App\Http\Controllers\MedicamentController::class, 'show'])
            ->name('medicament_show')
            ->middleware('Admin:MEDICAMENT_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\MedicamentController::class, 'edit'])
            ->name('medicament_edit')
            ->middleware('Admin:MEDICAMENT_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}', [App\Http\Controllers\MedicamentController::class, 'update'])
            ->name('medicament_update')
            ->middleware('Admin:MEDICAMENT_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\MedicamentController::class, 'destroy'])
            ->name('medicament_delete')
            ->where('id', '[0-9]+')
            ->middleware('Admin:MEDICAMENT_DELETE');
    });
});