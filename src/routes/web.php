<?php


Route::prefix('laravel-composer')->middleware(['web'])->group(function () {
    Route::get('/', '\EmtiazZahid\LaravelComposer\LaravelComposerController@index');

    Route::get('package-download/{name}/{version}', '\EmtiazZahid\LaravelComposer\LaravelComposerController@packageDownload')
        ->name('laravel-composer.package-download');

    Route::get('package-remove/{name}', '\EmtiazZahid\LaravelComposer\LaravelComposerController@packageRemove')
        ->name('laravel-composer.package-remove');

    Route::get('package-details/{name}', '\EmtiazZahid\LaravelComposer\LaravelComposerController@packageDetails')
        ->name('laravel-composer.package-details');

    Route::get('package-readme-view', '\EmtiazZahid\LaravelComposer\LaravelComposerController@readmeView')
        ->name('laravel-composer.package-readme-view');



    Route::get('list', '\EmtiazZahid\LaravelComposer\LaravelComposerController@getPackageList')
        ->name('laravel-composer.package-list');

    Route::get('search', '\EmtiazZahid\LaravelComposer\LaravelComposerController@searchPackage')
        ->name('laravel-composer.package-search');

});
