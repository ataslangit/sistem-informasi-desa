<?php

Route::get('/', 'main@index')->name('index');

Route::group('install', static function () {
    Route::get('/', 'main@initial')->name('install.view');
    Route::get('run', 'main@install')->name('install.run');
});
