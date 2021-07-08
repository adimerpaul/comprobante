<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return User::with('unid')->where('id','!=',1)->get();
    }
    public function login(Request $request){
        if (!Auth::attempt($request->all())){
            return response()->json(['res'=>'No existe el usuario'],400);
        }
        if (User::where('email',$request->email)->whereDate('fechalimite','>',now())->get()->count()==0){
            return response()->json(['res'=>'Su usuario sobre paso el limite de ingreso'],400);
        }

        $user=User::where('email',$request->email)->with('unid')->with('permisos')->firstOrFail();
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>$user],200);;
    }
    public function store(Request $request){
//        return ;
        return User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=> Hash::make($request->password) ,
            "unid_id"=>$request->unid_id,
            "fechalimite"=>$request->fechalimite,
            "codigo"=>$request->codigo,
        ]);
    }
    public function update(Request $request,User $user){
        $user->update($request->all());
        return $user;
    }
    public function destroy(User $user){
        $user->delete();
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['res'=>'salido exitosamente'],200);
    }
    public function me(Request $request){
        $user=$request->user()->with('unid')->with('permisos')->firstOrFail();
        return $user;

//        return User::where('id',1)->with('unid')->get();
    }
}
