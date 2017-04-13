<?php
Route::group(
    ['middleware' => ['web'],
    'as' => 'RoleManager::',
    'prefix' => trim(config('roleManager.routePrefix'), '/')],
    function () {
        Route::get(
            '/', 'Mamikon\RoleManager\Controllers\RoleManagerController@index'
        )->name('home');

        Route::get(
            '/user/{id}',
            'Mamikon\RoleManager\Controllers\RoleManagerController@edit'
        )->name('viewUserRole');

        Route::post(
            '/user/{id}',
            'Mamikon\RoleManager\Controllers\RoleManagerController@update'
        )->name('updateUserRole');

        Route::resource(
            '/role', 'Mamikon\RoleManager\Controllers\RoleController',
            ['except' => ['show']]
        );

        Route::resource(
            '/permission',
            'Mamikon\RoleManager\Controllers\PermissionController',
            ['except' => ['show']]
        );
    }
);