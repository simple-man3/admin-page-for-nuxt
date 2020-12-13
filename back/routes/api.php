<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'auth:api'],function (){
    Route::get('/auth/user',[AuthController::class,'getInfoAuthUSer']);
});

Route::post('/count-users',[AuthController::class ,'getCountUsers']);
Route::post('/registration-user',[AuthController::class,'registrationUser']);
