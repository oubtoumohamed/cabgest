<?php

Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'auth','prefix' => '/admin/__ModuleLower__/'], function () {

        Route::get('list', '__ModuleController__Controller@index')
            ->name('__ModuleLower__')
            ->middleware('Admin:ADMIN');
        
        Route::get('create', '__ModuleController__Controller@create')
            ->name('__ModuleLower___create')
            ->middleware('Admin:ADMIN');
        
        Route::post('create', '__ModuleController__Controller@store')
            ->name('__ModuleLower___store')
            ->middleware('Admin:ADMIN');
        
        Route::get('{id}/delete', '__ModuleController__Controller@destroy')
            ->name('__ModuleLower___delete')
            ->middleware('Admin:ADMIN')
            ->where('id', '[0-9]+');
        
        Route::get('{id}', '__ModuleController__Controller@show')
            ->name('__ModuleLower___show')
            ->middleware('Admin:ADMIN')
            ->where('id', '[0-9]+');
        
        Route::get('{id}/edit', '__ModuleController__Controller@edit')
            ->name('__ModuleLower___edit')
            ->middleware('Admin:ADMIN')
            ->where('id', '[0-9]+');
        
        Route::post('{id}', '__ModuleController__Controller@update')
            ->name('__ModuleLower___update')
            ->middleware('Admin:ADMIN')
            ->where('id', '[0-9]+');
    });
});