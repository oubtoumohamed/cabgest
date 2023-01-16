<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/leave/'], function () {

        Route::get('list', [App\Http\Controllers\LeaveController::class, 'index' ])
            ->name('leave')
            ->middleware('Admin:LEAVE_LIST');
        
        Route::get('create', [App\Http\Controllers\LeaveController::class, 'create' ])
            ->name('leave_create')
            ->middleware('Admin:LEAVE_CREATE');
        
        Route::post('create', [App\Http\Controllers\LeaveController::class, 'store' ])
            ->name('leave_store')
            ->middleware('Admin:LEAVE_CREATE');
        
        Route::get('{id}', [App\Http\Controllers\LeaveController::class, 'show' ])
            ->name('leave_show')
            ->middleware('Admin:LEAVE_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\LeaveController::class, 'edit' ])
            ->name('leave_edit')
            ->middleware('Admin:LEAVE_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}', [App\Http\Controllers\LeaveController::class, 'update' ])
            ->name('leave_update')
            ->middleware('Admin:LEAVE_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\LeaveController::class, 'destroy' ])
            ->name('leave_delete')
            ->middleware('Admin:LEAVE_DELETE')
            ->where('id', '[0-9]+');
    });
});
