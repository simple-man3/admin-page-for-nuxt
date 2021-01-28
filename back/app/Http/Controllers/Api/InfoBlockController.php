<?php

namespace App\Http\Controllers\Api;

use App\Classes\InfoBlockClass;
use App\Http\Controllers\Controller;
use App\Models\InfoBlock;
use App\Models\User;
use Illuminate\Http\Request;

class InfoBlockController extends Controller
{
    public function save(Request $request)
    {
        InfoBlock::create([
            'name'=>$request->nameInfoBlock,
            'active'=>true,
            'user_id'=>auth()->id()
        ]);
        return response([
            'result'=>'added',
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
}
