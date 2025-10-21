<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
     /**
     * Devuelve una lista de todos los descuentos activos (simula un índice administrativo).
     */
    public function index()
    {
        // Devolvemos todos los descuentos.
        return response()->json(Discount::all());
    }

    /**
     * Crea un nuevo descuento.
     * Endpoint: POST /api/discounts
     */
    public function store(Request $request)
    {
        // Validación estricta para asegurar que el descuento es usable
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'value' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed', // Solo se permiten 'percentage' o 'fixed'
            'expires_at' => 'required|date|after:now', // Debe ser una fecha futura
        ]);

        $validated['code'] = strtoupper($validated['code']);
        
        $discount = Discount::create($validated);
        
        return response()->json($discount, 201);
    }

    /**
     * Muestra los detalles de un descuento específico.
     * Endpoint: GET /api/discounts/{discount}
     */
    public function show(Discount $discount)
    {
        return response()->json($discount);
    }

    /**
     * Actualiza un descuento existente.
     * Endpoint: PUT/PATCH /api/discounts/{discount}
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'sometimes|required|string|max:50|unique:discounts,code,' . $discount->id,
            'value' => 'sometimes|required|numeric|min:0',
            'type' => 'sometimes|required|in:percentage,fixed',
            'expires_at' => 'sometimes|required|date|after_or_equal:today', 
        ]);

        if (isset($validated['code'])) {
            $validated['code'] = strtoupper($validated['code']);
        }

        $discount->update($validated);

        return response()->json($discount, 200);
    }

    /**
     * Elimina un descuento.
     * Endpoint: DELETE /api/discounts/{discount}
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(null, 204);
    }
}
