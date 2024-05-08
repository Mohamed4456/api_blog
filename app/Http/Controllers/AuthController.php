<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\hash;
use app\Models\User;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendError('validate errors', $validator->errors());
        }
        
        $input=$request->all();
        $input['password']=Hash::make($input['password']);
        $user = User::create($input);
        $success['token']=$user->createToken('mghawry')->accessToken;
        $success['name']=$user->name;
        return $this->sendResponse($success, 'User Register Success ' );

    }

    
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            /** @var \App\Models\User $user **/
            $user=Auth::user();
            $success['token']=$user->createToken('mghawry')->accessToken;
            $success['name']=$user->name;
            return $this->sendResponse($success, 'User login Success ' );
        }
        else
        {
            return $this->sendError('not correct',['error'=>'Unautorized']);
        }

}

}