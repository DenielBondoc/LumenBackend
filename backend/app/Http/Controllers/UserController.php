<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register', 'showAllUser', 'me']]);
    }                                      

    public function showAllUser()
    {
        return response()->json(User::all());
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $input = $request->only('name', 'email', 'password');

        try {
            $user = new User;
            $user->name = $input['name'];
            $user->email = $input['email'];
            $password = $input['password'];
            $user->password = app('hash')->make($password);

            if( $user->save() ){
                $code = 200;
                $output = [
                    'user' => $user,
                    'code' => $code,
                    'message' => 'User created successfully.'
                ];
            }else {
                $code = 500;
                $output = [
                    'code' => $code,
                    'message' => 'An error while creating user.'
                ];
            }
        }catch (Exception $e) {
            $code = 500;
            $output = [
                'code' => $code,
                'message' => 'An error while creating user.'
            ];
        }

        return response()->json($output, $code);
    }

    public function login(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $input = $request->only('email', 'password');

        if(!$authorized = Auth::attempt($input)) {
            $code = 401;
            $output = [
                'code' => $code,
                'message' => 'User is not authorized.'
            ];
        }else {
            $code = 201;
            $token = $this->respondWithToken($authorized);
            $output = [
                'code' => $code,
                'message' => 'User logged in successfully.',
                'token' => $token
            ];
        }

        return response()->json($output, $code);
    }

    public function me(){
        return response()->json($this->guard()->user());
    }

    public function refresh(){
        return $this->respondWithToken( $this->guard()->refresh() );
    }

    public function logout(){
        $this->guard()->logout();
        return response()->json(['message' => 'Logged Out!']);
    }

    public function guard(){
        return Auth::guard();
    }
}
