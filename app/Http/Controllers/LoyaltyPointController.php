<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;

class LoyaltyPointController extends Controller
{
    /**
     * Muestra una lista de los puntos de lealtad.
     */
    public function index()
    {
        // Devuelve todos los registros de puntos de lealtad con su usuario asociado.
        return LoyaltyPoint::with('user')->get();
    }

    /**
     * Almacena un nuevo registro de puntos de lealtad.
     */
    public function store(Request $request)
    {
        // Valida la solicitud para asegurar los datos requeridos.
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points_earned' => 'required|integer|min:0',
            'points_redeemed' => 'required|integer|min:0',
        ]);
        
        $loyaltyPoint = LoyaltyPoint::create($request->all());
        return response()->json($loyaltyPoint, 201);
    }

    /**
     * Muestra un registro de puntos de lealtad específico.
     */
    public function show(LoyaltyPoint $loyaltyPoint)
    {
        // Devuelve el registro de puntos de lealtad, cargando el usuario relacionado.
        return $loyaltyPoint->load('user');
    }

    /**
     * Actualiza un registro de puntos de lealtad.
     */
    public function update(Request $request, LoyaltyPoint $loyaltyPoint)
    {
        // Valida los datos de actualización.
        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'points_earned' => 'sometimes|required|integer|min:0',
            'points_redeemed' => 'sometimes|required|integer|min:0',
        ]);
        
        $loyaltyPoint->update($request->all());
        return response()->json($loyaltyPoint, 200);
    }

    /**
     * Elimina un registro de puntos de lealtad.
     */
    public function destroy(LoyaltyPoint $loyaltyPoint)
    {
        $loyaltyPoint->delete();
        return response()->json(null, 204);
    }
}