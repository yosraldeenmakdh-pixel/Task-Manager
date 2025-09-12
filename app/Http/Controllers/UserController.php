<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\MsgStartMail;
use App\Models\Task;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:255' ,
            'email'=>'required|string|email|unique:users,email|max:255' ,
            'password'=>'required|string|min:8|confirmed' ,
        ]) ;
        $user = User::create([
            'name'=>$request->name ,
            'email'=>$request->email ,
            'password'=>Hash::make($request->password) ,
        ]) ;
        Mail::to($request->email)->send(new MsgStartMail($user)) ;
        return response()->json(
            ['message'=>'User Registered successfully',
            'user'=>$user], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|string|email' ,
            'password'=>'required|string' ,
        ]) ;
        if(!Auth::attempt($request->only('email','password')))
            return response()->json(['message'=>'invalid password or email'], 401);
        $user = User::where('email',$request->email)->firstOrFail() ;
        $token = $user->createToken('auth_token')->plainTextToken ;
        return response()->json([
            'message'=>'login successfully' ,
            'user'=>$user ,
            'token'=>$token
        ], 200);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete() ;
        return response()->json(['message'=>'logout successfully']);
    }


    public function getTasks($id){
        $tasks = User::findOrFail($id)->tasks ;
        return response()->json($tasks, 200);
    }
    public function getuser($id){
        $user = Task::findOrFail($id)->user ;
        return response()->json($user, 200);
    }

    public function userInfo(){
        $userData = User::with('profile')->with('tasks')
        ->with('favoriteTask')->findOrFail(Auth::user()->id) ;
        // return response()->json($userData, 200);
        return new UserResource($userData) ;
    }


}
