<?php

namespace App\Classes;

use App\Models\AdditionalFields;

class AdditionalFieldClass
{
    static function saveAdditionalField($arResult,$idInfoBlock)
    {
        $Array=[];
        foreach ($arResult as $key=>$value){
            AdditionalFields::create([
                'name'=>$value['name'],
                'active'=>true,
                'symbol_code'=>$value['symbolCode'],
                'type_fields_id'=>$value['typeField'],
                'info_block_id'=>$idInfoBlock['id'],
                'needFill'=>$value['needFill'],
            ]);
        }
    }

    /**
     * Проверяет уникальность символьного кода
     * @param $arData => массив символьных кодов
     * @return array => выводит массив сущесвующих символьных кодов. Если выводимый массив пуст, то символьные коды уникальны
     */
    static function checkUniqueSymbolCode($arData)
    {
        $arResult=[];
        foreach ($arData as $value) {
            if (
                !is_null(AdditionalFields::where('symbol_code',$value)->first())
            ) {
                array_push($arResult,$value);
            }
        }

        return $arResult;
    }
}
