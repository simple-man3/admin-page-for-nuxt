<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'auth:api'],function (){
    Route::get('/auth/user',[AuthController::class,'getInfoAuthUSer']);
});
