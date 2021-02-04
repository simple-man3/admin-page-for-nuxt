<?php

namespace App\Http\Controllers\Api\Admin;

use App\Classes\AdditionalFieldClass;
use App\Classes\InfoBlockClass;
use App\Http\Controllers\Controller;
use App\Models\InfoBlock;
use App\Models\TypeFields;
use App\Models\User;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class InfoBlockController extends Controller
{
    public function save(Request $request)
    {
        $idInfoBlock=InfoBlockClass::saveInfoBlock($request->input('nameInfoBlock'));
        AdditionalFieldClass::saveAdditionalField($request->input('arAdditionalFields'), $idInfoBlock);

        return response([
            'result'=>$request->all(),
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
        $infoBlock['user']=$infoBlock->user;
        unset($infoBlock['user_id']);

        return response([
            'result'=>$infoBlock
        ],200);
    }

    public function updateInfoBlock(Request $request)
    {
        $Array=$request->input('arData');
        return response([
            'result'=>InfoBlock::find($Array['id'])->update([
                'name'=>$Array['name'],
                'active'=>$Array['active'],
            ])
        ],200);
    }

    public function massAction(Request $request)
    {
        return response([
            'result'=>InfoBlockClass::massAction($request->except('token'))
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
            'result'=>AdditionalFieldClass::checkUniqueSymbolCode($request->input('arSymbolCode'))
        ],200);
    }
}
