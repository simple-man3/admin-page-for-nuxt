<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\InfoBlockController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'auth:api'],function (){
    Route::get('/auth/user',[AuthController::class,'getInfoAuthUser']);

    //region Инфоблок
    Route::prefix('admin/info-block')->group(function (){
        // Создаёт инфоблок
        Route::post('create-info-block',[InfoBlockController::class,'save']);

        // Выдает весь список инфоблоков
        Route::post('get-all-info-block',[InfoBlockController::class,'getAllInfoBlocks']);

        // Выдает определенный инфоблок
        Route::post('get-current-info-block',[InfoBlockController::class ,'getCurrentInfoBlock']);

        // Обновляет инфоблок
        Route::post('update',[InfoBlockController::class ,'updateInfoBlock']);

        // Массовые/единичные действия над инфоблоком
        Route::post('mass-action',[InfoBlockController::class,'massAction']);

        // Выдаёт список типов полей
        Route::get('get-type-fields',[InfoBlockController::class,'getAllTypeInfoBlocks']);

        // Проверяет уникальность символьного кода
        Route::post('check-unique-symbol-code',[InfoBlockController::class,'checkUniqueSymbolCode']);

        // Проверяет выбранное поле
        Route::post('delete-current-field',[InfoBlockController::class,'deleteCurrentField']);
    });
    //endregion

    //region Контент
    Route::prefix('admin/content')->group(function (){
//        Route::get('get-all-in');
    });
    //endregion
});

Route::post('/count-users',[AuthController::class ,'getCountUsers']);
Route::post('/registration-user',[AuthController::class,'registrationUser']);
