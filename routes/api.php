<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user_info', [ApiController::class, 'get_userInfo']);
    Route::get('get_user/{userId}', [ApiController::class, 'get_user']);
    Route::put('update',  [ApiController::class, 'update']);
    Route::post('addcontact', [ApiController::class, 'insertNewContact']);
    Route::get('getcontacts', [ApiController::class, 'getMyContacts']);
});

