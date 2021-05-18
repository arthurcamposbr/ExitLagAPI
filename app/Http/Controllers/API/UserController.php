<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Exibe dados do usuário.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if($user){
            return response()->json([
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Usuário não autorizado.',
            ], 401);
        }

    }

    /**
     * Login.
     */
    public function login(Request $request)
    {
        $data = $request->all();

        $validacao = Validator::make($data, [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string',
        ]);

        if($validacao->fails()){
            return response()->json([
                'success'=>false, "msg"=>$validacao->errors()
            ], 400);
        }

        if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;

            return response()->json([
                'success'=>true, 'user' => $user,
            ], 200);

        } else {
            return response()->json([
                'msg' => 'E-mail ou senha incorretos.',
            ], 401);
        }

    }

    /**
     * Cadastro usuário.
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $validacao = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if($validacao->fails()){
            return ['success'=>false, "msg"=>$validacao->errors()];
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(40)
        ]);

        $braintree = config('braintree');

        $result = $braintree->customer()->create([
            'firstName' => $data['name'],
            'email' => $data['email']
        ]);

        $user->customer()->create([
            'code' => $result->customer->id,
            'gateway_id' => 1
        ]);

        $user->token = $user->createToken($user->email)->accessToken;

        return response()->json([
            'success'=>true, 'user' => $user,
        ], 200);

    }

}
