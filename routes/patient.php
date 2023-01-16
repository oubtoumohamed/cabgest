<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/patient/'], function () {

        Route::get('list', [App\Http\Controllers\PatientController::class, 'index' ])
            ->name('patient')
            ->middleware('Admin:PATIENT_LIST');

        Route::get('ajaxlist', [App\Http\Controllers\PatientController::class, 'ajaxlist' ])
            ->name('patient_ajaxlist');
        
        Route::get('create', [App\Http\Controllers\PatientController::class, 'create' ])
            ->name('patient_create')
            ->middleware('Admin:PATIENT_CREATE');
        
        Route::post('create', [App\Http\Controllers\PatientController::class, 'store' ])
            ->name('patient_store')
            ->middleware('Admin:PATIENT_CREATE');
        
        Route::get('{id}/show', [App\Http\Controllers\PatientController::class, 'show' ])
            ->name('patient_show')
            ->middleware('Admin:PATIENT_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\PatientController::class, 'edit' ])
            ->name('patient_edit')
            ->middleware('Admin:PATIENT_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}/update', [App\Http\Controllers\PatientController::class, 'update' ])
            ->name('patient_update')
            ->middleware('Admin:PATIENT_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\PatientController::class, 'destroy' ])
            ->name('patient_delete')
            ->middleware('Admin:PATIENT_DELETE')
            ->where('id', '[0-9]+');
    });
});
