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
    // 1. Validar la solicitud, incluyendo la lista de ítems
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id', 
        'discount_id' => 'nullable|exists:discounts,id',
        'status' => 'required|string|in:pending,processing,ready,completed,canceled',
        'total_price' => 'required|numeric|min:0',
        'delivery_option' => 'required|string|in:pickup,delivery',
        'delivery_address' => 'nullable|string',
        'pickup_time' => 'nullable|date_format:H:i:s',
        'tracking_code' => 'required|string|unique:orders',
        
        // --- Validación de los ítems del carrito ---
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.customization_details' => 'nullable|string|max:500', // El resumen de personalización
    ]);
    
    // 2. Crear la orden principal (solo campos de la tabla 'orders')
    $order = Order::create([
        'user_id' => $validatedData['user_id'],
        'discount_id' => $validatedData['discount_id'],
        'status' => $validatedData['status'],
        'total_price' => $validatedData['total_price'],
        'delivery_option' => $validatedData['delivery_option'],
        'delivery_address' => $validatedData['delivery_address'],
        'pickup_time' => $validatedData['pickup_time'],
        'tracking_code' => $validatedData['tracking_code'],
    ]);
    
    // 3. Crear los ítems del pedido (OrderItems)
    foreach ($validatedData['items'] as $itemData) {
        // Usamos la relación definida en el modelo Order
        $order->items()->create([
            'product_id' => $itemData['product_id'],
            'quantity' => $itemData['quantity'],
            'unit_price' => $itemData['unit_price'],
            'customization_details' => $itemData['customization_details'],
            // Laravel automáticamente añade 'order_id'
        ]);
    }

    // 4. Retornar la respuesta al cliente Flutter (código 201 Created)
    return response()->json($order->load(['user', 'items']), 201);
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