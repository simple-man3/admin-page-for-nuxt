<?php

namespace App\Classes;

use App\Models\InfoBlock;

class InfoBlockClass
{
    static function massAction($request)
    {
        if ($request['action']=='active')
            self::activateInfoBlocks($request['arSelected']);
        if ($request['action']=='disable')
            self::disableInfoBlocks($request['arSelected']);
        if ($request['action']=='delete')
            self::deleteInfoBlocks($request['arSelected']);

        return $request['arSelected'];
    }

    static function activateInfoBlocks($arId)
    {
        foreach ($arId as $value) {
            InfoBlock::find($value)->update([
                'active'=>true
            ]);
        }
    }

    static function disableInfoBlocks($arId)
    {
        foreach ($arId as $value) {
            InfoBlock::find($value)->update([
                'active'=>false
            ]);
        }
    }

    static function deleteInfoBlocks($arId)
    {
        foreach ($arId as $item) {
            InfoBlock::find($item)->additionalField()->delete();
            InfoBlock::destroy($item);
        }
    }

    static function getSelectedInfoBlocks($arId)
    {
        $arResult=[];

        foreach ($arId as $value) {
            array_push($arResult,InfoBlock::find($value));
        }

        return $arResult;
    }

    static function saveInfoBlock($name)
    {
        $infoBlock=InfoBlock::create([
            'name'=>$name,
            'active'=>true,
            'user_id'=>auth()->id(),
        ]);

        return $infoBlock;
    }
}
