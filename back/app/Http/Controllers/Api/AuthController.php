<?php

namespace App\Http\Controllers\Api;

use App\Classes\Registration;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getInfoAuthUSer()
    {
        return auth()->user();
    }

    public function getCountUsers(Request $request)
    {
        return response([
            'result'=>User::count()
        ],200);
    }

    public function registrationUser(Request $request)
    {
        Registration::setUserRole(null, $request->except('_token'));

        return response([
            'result'=>'user added'
        ],200);
    }
}
