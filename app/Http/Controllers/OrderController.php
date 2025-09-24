<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Muestra una lista de todas las órdenes.
     */
    public function index()
    {
        // Devuelve todas las órdenes con sus relaciones precargadas.
        return Order::with(['user', 'discount', 'items'])->get();
    }

    /**
     * Almacena una nueva orden.
     */
    public function store(Request $request)
    {
        // Valida la solicitud antes de crear la orden.
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'status' => 'required|string|in:pending,processing,ready,completed,canceled',
            'total_price' => 'required|numeric|min:0',
            'delivery_option' => 'required|string|in:pickup,delivery',
            'delivery_address' => 'nullable|string',
            'pickup_time' => 'nullable|date_format:H:i:s',
            'tracking_code' => 'required|string|unique:orders',
        ]);
        
        $order = Order::create($request->all());
        
        return response()->json($order, 201);
    }

    /**
     * Muestra una orden específica.
     */
    public function show(Order $order)
    {
        // Devuelve una orden específica, cargando todas sus relaciones.
        return $order->load(['user', 'discount', 'items']);
    }

    /**
     * Actualiza una orden existente.
     */
    public function update(Request $request, Order $order)
    {
        // Valida los datos de actualización.
        $request->validate([
            'status' => 'sometimes|required|string|in:pending,processing,ready,completed,canceled',
            'total_price' => 'sometimes|required|numeric|min:0',
            'delivery_option' => 'sometimes|required|string|in:pickup,delivery',
            'delivery_address' => 'nullable|string',
            'pickup_time' => 'nullable|date_format:H:i:s',
        ]);
        
        $order->update($request->all());
        
        return response()->json($order, 200);
    }

    /**
     * Elimina una orden.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        
        return response()->json(null, 204);
    }
}