<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Corregido: 'USE' a 'use' y coherencia

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255', // Añadido max:255 para buena práctica
            'email' => 'required|string|email|unique:users|max:255', // Añadido 'email' para validación de formato y max:255
            'password' => 'required|string|min:6', // Añadido 'confirmed' para requerir password_confirmation
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Cambio 1: Corregido el 'redirect()->json' a 'response()->json'
            // Ya que un redirect no tiene sentido en una API o un error de validación JSON.
            return response()->json($validator->errors(), 422); // Usar 422 (Unprocessable Entity) es estándar para errores de validación
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user = $user->fresh();

        // Corregido un pequeño error tipográfico en el nombre del token
        $token = $user->createToken('Personal Access Token')->plainTextToken; // 'Acess' a 'Access'

        // Cambio 2: Corregido error tipográfico en la variable 'resonse' a 'response'
        $response = [
            'user' => $user, 
            'token' => $token
        ];

        return response()->json($response, 201); // Usar 201 (Created) es más apropiado para una creación exitosa
    }

    public function login(Request $request){
        $rules = [
            'email' => 'required',
            'password' => 'required|string'
        ];

         $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); 
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Personal Acesss Token')->plainTextToken;
            $response = ['user' => $user ,'token'=> $token ];
            return response()->json($response, 200);
        }
           $response = ['message' => 'Incorrect email or password'];
           return response()->json($response, 400);
    }

     public function logout(Request $request)
    {
        // Revoca el token de acceso actual (el que se usó para esta petición)
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada exitosamente.'], 200);
    }
}