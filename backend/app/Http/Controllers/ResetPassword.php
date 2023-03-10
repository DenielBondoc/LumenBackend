<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class ResetPassword extends Controller
{
    public function sendEmail(Request $request) 
    {
        if(!$this->validateEmail($request->email)) 
        {
            return $this->failedResponse();
        }

        $this->send($request->email);
        return $this->successResponse();

    }

    public function send($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token,$email));
    }

    public function createToken($email){
        $oldToken = DB::table('password_resets')->where('email',$email)->first();
        if($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(40);
        $this->saveToken($token,$email);
        return $token;
    }

    public function saveToken($token,$email){
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function validateEmail($email)
    {
        return !!User::where('email',$email)->first();
    }

    public function failedResponse(){
        return response()->json([
            'error' => 'Email dont exist in data base'
        ]);
    }

    public function successResponse(){
        return response()->json([
            'data' => 'Reset email sent'
        ]);
    }
}
