<?php
use App\Http\Controllers\Api\UserController;

Route::group(['controller' => UserController::class, 'middleware' => ['jwt.auth']], function () {
    Route::get('/user/list', 'list');
    Route::get('/user/detail/{user}', 'detail');
    Route::post('/user/add', 'add');
    Route::put('/user/update/{user}', 'update');
    Route::delete('/user/remove/{user}', 'remove');
});
