<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class UserController extends Controller
{
public function register(Request $request){
$user =new User;
$user->name=$request->name;
$user->email=$request->email;
$user->password=bcrypt($request->password);
$user->save();
return response()->json(['status'=>'success','data'=>$user]);



}
public function login()
{
    $credentials = request(['email', 'password']);

    if ($token = auth()->attempt($credentials)) {
        return response()->json(['status'=>'success','token'=>$token]);

    }
    return response()->json(['status'=>'erorr']);


}

}
