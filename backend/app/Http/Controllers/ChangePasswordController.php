<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    public function process(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        return $this->getPasswordResetTableRow($request)->count()> 0 ? $this->changePassword($request) : $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request){


        return DB::table('password_resets')->where(['email'=>$request->email, 'token'=>$request->resetToken]);
    }

    private function tokenNotFoundResponse(){
        return response()->json(['error' => 'Token or email is incorrect']);
    }

    private function changePassword($request){

        $user = User::whereEmail($request->email)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json(['data'=>'Password Successfully changed']);
    }
}
