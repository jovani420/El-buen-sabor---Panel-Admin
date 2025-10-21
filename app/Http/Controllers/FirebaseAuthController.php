<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception; // Importar la clase base para el catch general

class FirebaseAuthController extends Controller
{
    protected Auth $firebaseAuth;

    public function __construct(Auth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function login(Request $request)
    {
        $idToken = $request->bearerToken();
        
        if (!$idToken) {
            return response()->json(['error' => 'No se proporcionó el Firebase ID Token'], 401);
        }

        try {
            // 1. Verificar el token con el Firebase Admin SDK
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);

            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name') ?? 'Usuario Google';

            // 2. Buscar o crear el usuario en la DB de Laravel
            $user = User::where('firebase_uid', $uid)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'firebase_uid' => $uid,
                    'password' => Hash::make(Str::random(20)), 
                ]);
            }

            // 3. Generar y devolver el token de Sanctum
            $sanctumToken = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Autenticación exitosa',
                'sanctum_token' => $sanctumToken,
            ], 200);

        } catch (Exception $e) { 
            // EL USO DE LA BARRA INVERTIDA (\) SOLUCIONA EL PROBLEMA PARA PHP.
            // Si el linter sigue mostrando el error, la causa es el punto 2.
            return response()->json(['error' => 'Token de Firebase inválido o expirado.'], 401);
        } catch (Exception $e) {
            // Manejo de otros errores generales
            return response()->json(['error' => 'Fallo en la autenticación: ' . $e->getMessage()], 401);
        }
    }
}
