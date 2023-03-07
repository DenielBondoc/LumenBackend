<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


class ResetPassword extends Controller
{
    public function sendEmail(Request $request){
    if(!$this->validateEmail($request->email)) {
        return $this->failedResponse();
        }

        $this->send($request->email);
        return $this->successResponse();

    }

    public function send($email){
        
        $token = $this->createToken();
        Mail::to($email)->send(new ResetPasswordMail);
    }

    public function validateEmail($email){
        return !!User::where('email', $email)->first();
    }

    public function failedResponse(){
        return response()->json([
            'error' => 'Email doesn\'t found on our database'
        ]);
    }

    public function successResponse(){
        return response()->json([
            'error' => 'Reset Email is sent'
        ]);
    }
}
