<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/rendezvous/'], function () {

        Route::get('list', [App\Http\Controllers\RendezvousController::class, 'index'])
            ->name('rendezvous')
            ->middleware('Admin:RENDEZVOUS_LIST');
        
        Route::get('create', [App\Http\Controllers\RendezvousController::class, 'create'])
            ->name('rendezvous_create')
            ->middleware('Admin:RENDEZVOUS_CREATE');
        
        Route::post('create', [App\Http\Controllers\RendezvousController::class, 'store'])
            ->name('rendezvous_store')
            ->middleware('Admin:RENDEZVOUS_CREATE');
        
        Route::get('{id}', [App\Http\Controllers\RendezvousController::class, 'show'])
            ->name('rendezvous_show')
            ->middleware('Admin:RENDEZVOUS_SHOW')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', [App\Http\Controllers\RendezvousController::class, 'edit'])
            ->name('rendezvous_edit')
            ->middleware('Admin:RENDEZVOUS_EDIT')
            ->where('id', '[0-9]+');
        
        Route::post('{id}', [App\Http\Controllers\RendezvousController::class, 'update'])
            ->name('rendezvous_update')
            ->middleware('Admin:RENDEZVOUS_EDIT')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/delete', [App\Http\Controllers\RendezvousController::class, 'destroy'])
            ->name('rendezvous_delete')
            ->middleware('Admin:RENDEZVOUS_DELETE')
            ->where('id', '[0-9]+');
    });
});