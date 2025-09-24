<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     */
    public function index()
    {
        // Devuelve todos los usuarios con sus pedidos y puntos de lealtad.
        return User::with(['orders', 'loyaltyPoints'])->get();
    }

    /**
     * Almacena un nuevo usuario.
     */
    public function store(Request $request)
    {
        // Valida la solicitud antes de crear un nuevo usuario.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    /**
     * Muestra un usuario específico.
     */
    public function show(User $user)
    {
        // Devuelve un usuario específico, cargando sus pedidos y puntos de lealtad.
        return $user->load(['orders', 'loyaltyPoints']);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, User $user)
    {
        // Valida los datos de actualización, ignorando el email del usuario actual.
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);
        
        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json($user, 200);
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return response()->json(null, 204);
    }
}