<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
class UserController extends Controller
{
    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

            $user = Auth::user();
            $access_token =  $user->createToken('access_token');
            $str_access_token = $access_token->accessToken;
            $todayDate = Carbon::now();
            $expiration = $access_token->token->expires_at;


            return response()->json([
                'user' => $user,
                'expires_in' => $expiration,
                'access_token' => $str_access_token,
                'status' => 'Login Successfully'
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'Email atau password masih salah. Coba ulang kembali'
            ], 401);
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(
               [ 'error'=>$validator->errors()]
            ,401);
        }

        $data = Product::all();
        $formRegister = $request->all();
        $formRegister['password'] = bcrypt($formRegister['password']);
        $user = User::create($formRegister);

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }
}
