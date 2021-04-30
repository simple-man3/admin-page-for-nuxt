<?php

namespace App\Classes;

use App\Models\AdditionalFields;

class AdditionalFieldClass
{
    static function saveAdditionalField($arResult,$idInfoBlock)
    {
        foreach ($arResult as $key=>$value){
            AdditionalFields::create([
                'name'=>$value['name'],
                'active'=>true,
                'symbol_code'=>$value['symbol_code'],
                'type_fields_id'=>$value['type_fields_id'],
                'info_block_id'=>$idInfoBlock,
                'needFill'=>$value['needFill'],
            ]);
        }
    }

    /**
     * Проверяет уникальность символьного кода
     * @param $arData => массив символьных кодов
     * @return {boolean, array}
     * unique => true если все значения уникальны
     * arDuplicate => массив дублирующиеся данных
     */
    static function isUniqueSymbolCode($arData)
    {
        $arDuplicate=[];
        foreach (array_unique($arData) as $value) {
            if (!is_null(AdditionalFields::where('symbol_code',$value)->first())) {
                array_push($arDuplicate,$value);
            }
        }

        return [
            'unique'=>sizeof($arDuplicate)==0,
            'arDuplicate'=>$arDuplicate
        ];
    }

    static function deleteCurrentField($id)
    {
        AdditionalFields::destroy($id);
    }

    /**
     * Изменяет данные в дополнительных полях
     * @param $arData => Указывается вложенный массив данных дополнительных полей. Имеет вид:
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
     */
    static function updateAdditionalFields($arData)
    {
        foreach ($arData as $arItem) {
            AdditionalFields::find($arItem['id'])->update([
                'name'=>$arItem['name'],
                'active'=>$arItem['active'],
                'needFill'=>$arItem['needFill'],
                'symbol_code'=>$arItem['symbol_code'],
                'type_fields_id'=>$arItem['type_fields_id'],
            ]);
        }
    }
}
