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
     * name => string
     * arAdditionalFields => указывается список существующих и новых дополнительных полей. Имеет вид:
     * [
     *      {
     *          name:string, => название
     *          active:boolean, => активность
     *          needFill:boolean, => обязательно заполнить пользователю
     *          symbol_code:string, => символьный код
     *          type_fields_id:number, => ID типа поля
     *      },
     *      ...
     * ]
     */
    public function save(Request $request)
    {
        if (is_null($request->input('arAdditionalFields')) || is_null($request->input('name'))) {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Недостаточно данных'
                ]
            ], 400);
        } elseif (gettype($request->input('name'))!='string' || gettype($request->input('arAdditionalFields'))!='array') {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Неверные типы данных'
                ]
            ], 400);
        } else {
            $idInfoBlock=InfoBlockClass::saveInfoBlock($request->input('name'));
            AdditionalFieldClass::saveAdditionalField($request->input('arAdditionalFields'), $idInfoBlock['id']);
        }

        return response([
            'result'=>gettype($request->input('arAdditionalFields')),
        ],200);
    }

    /**
     * @param Request $request - входят следующие атрибуты:
     * usePaginate => boolean. Обязательный параметр. Если true, то используется пагинация
     * count => количество постов на станицу
     */
    public function getAllInfoBlocks(Request $request)
    {
        return response([
            'result'=>$request->input('usePaginate')? InfoBlock::paginate($request->input('count')):InfoBlock::all(),
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
     * arAdditionalFields => указывается список существующих и новых дополнительных полей. Имеет вид:
     * [
     *      newFields=>[
     *          {
     *              id:number, => ID
     *              name:string, => название
     *              active:boolean, => активность
     *              needFill:boolean, => обязательно заполнить пользователю
     *              symbol_code:string, => символьный код
     *              type_fields_id:number, => ID типа поля
     *          },
     *          ...
     *      ],
     *      newFields=>[
     *          {
     *              name:string, => название
     *              active:boolean, => активность
     *              needFill:boolean, => обязательно заполнить пользователю
     *              symbol_code:string, => символьный код
     *              type_fields_id:number, => ID типа поля
     *          },
     *          ...
     *      ]
     * ]
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
            gettype($request->input('active'))!='integer'
        ) {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Неверные типы данных'
                ]
            ], 400);
        } elseif ($request->input('name')=='') {
            return response([
                'code' => 400,
                'error' => [
                    'message' => 'Название инфоблока не должно быть пустым'
                ]
            ], 400);
        } else {
            InfoBlock::find($request->input('id'))->update([
                'name'=>$request->input('name'),
                'active'=>$request->input('active'),
            ]);
            AdditionalFieldClass::updateAdditionalFields($request->input('arAdditionalFields')['existFields']);
            AdditionalFieldClass::saveAdditionalField($request->input('arAdditionalFields')['newFields'],$request->input('id'));
        }
        return response([
            'result'=>'updated',
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
