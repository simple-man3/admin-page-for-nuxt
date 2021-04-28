<?php

namespace App\Http\Controllers\Api\Admin;

use App\Classes\AdditionalFieldClass;
use App\Classes\InfoBlockClass;
use App\Http\Controllers\Controller;
use App\Models\AdditionalFields;
use App\Models\InfoBlock;
use App\Models\TypeFields;
use App\Models\User;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class InfoBlockController extends Controller
{
    /**
     * @param Request $request => в запросе должно быть:
     * arAdditionalFields => string
     * nameInfoBlock => [{...}, ...]
     */
    public function save(Request $request)
    {
        if (is_null($request->input('arAdditionalFields')) || is_null($request->input('nameInfoBlock'))) {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Недостаточно данных'
                ]
            ], 400);
        } elseif (gettype($request->input('nameInfoBlock'))!='string' || gettype($request->input('arAdditionalFields'))!='array') {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Неверные типы данных'
                ]
            ], 400);
        } else {
            $idInfoBlock=InfoBlockClass::saveInfoBlock($request->input('nameInfoBlock'));
            AdditionalFieldClass::saveAdditionalField($request->input('arAdditionalFields'), $idInfoBlock);
        }

        return response([
            'result'=>gettype($request->input('arAdditionalFields')),
        ],200);
    }

    public function getAllInfoBlocks(Request $request)
    {
        return response([
            'result'=>InfoBlock::paginate(7),
        ],200);
    }

    public function getCurrentInfoBlock(Request $request)
    {
        $infoBlock=InfoBlock::find($request->input('idInfoBlock'));

        $infoBlock->additionalField;

        $infoBlock['user']=$infoBlock->user;
        unset($infoBlock['user_id']);

        return response([
            'result'=>$infoBlock,
            'arTypeField'=>TypeFields::all(),
        ],200);
    }

    public function massAction(Request $request)
    {
        return response([
            'result'=>InfoBlockClass::massAction($request->except('token'))
        ],200);
    }

    /**
     * Изменяет данные в выбранном инфоблоке
     * @param Request $request => включает следующие атрибуты:
     * id => идентификатор инфоблока,
     * name => название инфоблока
     * active => активность инфоблока
     * additionalFieldsExist => необязательный параметр, где указывается список существующих дополнительных полей. Имеет вид:
     * [
     *  {
     *      id:number, => ID
     *      name:string, => название
     *      active:boolean, => активность
     *      needFill:boolean, => обязательно заполнить пользователю
     *      symbol_code:string, => символьный код
     *      type_fields_id:number, => ID типа поля
     *  }
     *  ...
     * ]
     * additionalFieldsExist => необязательный параметр, указывается список новых дополнительных полей. Структура такая же, как и у additionalFieldsExist, за исключением id, который не нужно указывать
     */
    public function updateInfoBlock(Request $request)
    {
        if (
            is_null($request->input('id')) ||
            is_null($request->input('name')) ||
            is_null($request->input('active'))
        ) {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Недостаточно данных'
                ]
            ], 400);
        } elseif (
            gettype($request->input('id'))!='integer' ||
            gettype($request->input('name'))!='string' ||
            gettype($request->input('active'))!='boolean'
        ) {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Неверные типы данных'
                ]
            ], 400);
        } elseif ($request->input('name')!='') {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Название инфоблока не должно быть пустым'
                ]
            ], 400);
        } else {
            InfoBlock::find()->update([
                'name'=>$request->input('name'),
                'active'=>$request->input('active'),
            ]);
            AdditionalFieldClass::updateAdditionalFields($request->input('additionalFieldsExist'));
        }
        return response([
            'result'=>'updated'
        ],200);
    }

    public function getAllTypeInfoBlocks()
    {
        return response([
            'result'=>TypeFields::orderBy('name','asc')->get()
        ],200);
    }

    public function checkUniqueSymbolCode(Request $request)
    {
        return response([
            'result'=>AdditionalFieldClass::isUniqueSymbolCode($request->input('arSymbolCode')),
        ],200);
    }

    public function deleteCurrentField(Request $request)
    {
        AdditionalFieldClass::deleteCurrentField($request->input('idField'));

        return response([
            'result'=>'deleted'
        ],200);
    }
}
