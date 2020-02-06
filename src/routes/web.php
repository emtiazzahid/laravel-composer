<?php


Route::prefix('laravel-composer')->middleware(['web'])->group(function () {

    Route::get('package-download/{name}/{version}', '\EmtiazZahid\LaravelComposer\LaravelComposerController@packageDownload')
        ->name('laravel-composer.package-download');

    Route::get('package-remove/{name}', '\EmtiazZahid\LaravelComposer\LaravelComposerController@packageRemove')
        ->name('laravel-composer.package-remove');

    Route::get('package-details/{name}', '\EmtiazZahid\LaravelComposer\LaravelComposerController@packageDetails')
        ->name('laravel-composer.package-details');
});
