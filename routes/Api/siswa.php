<?php
use App\Http\Controllers\Api\SiswaController;

Route::group(['controller' => SiswaController::class, 'middleware' => ['jwt.auth']], function () {
    Route::post('/siswa/sync', 'sync');
    Route::get('/siswa/list', 'list');
    Route::get('/siswa/detail/{siswa}', 'detail');
});
