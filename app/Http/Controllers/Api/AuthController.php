<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function signin (Request $request)
    {
        $usuario = User::firstOrNew(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password)
            ]
        );

        if ($usuario->id) {
            return response()->json([
                'type' => 'error',
                'msg' => 'Esse usuário já existe.',
            ], 500);
        }

        $usuario->save();
        return response()->json([
            'type'=> 'success',
            'msg' => 'Usuário criado com sucesso.'
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'type'=> 'success',
            'msg' => 'Deslogado com sucesso.'
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
