<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Muestra una lista de todos los ítems de pedido.
     */
    public function index()
    {
        // Devuelve todos los ítems de pedido con sus relaciones precargadas.
        return OrderItem::with(['order', 'product'])->get();
    }

    /**
     * Almacena un nuevo ítem de pedido.
     */
    public function store(Request $request)
    {
        // Valida la solicitud antes de crear el ítem.
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customizations' => 'nullable|json',
            'subtotal' => 'required|numeric|min:0',
        ]);
        
        $orderItem = OrderItem::create($request->all());
        
        return response()->json($orderItem, 201);
    }

    /**
     * Muestra un ítem de pedido específico.
     */
    public function show(OrderItem $orderItem)
    {
        // Devuelve un ítem de pedido específico, cargando sus relaciones.
        return $orderItem->load(['order', 'product']);
    }

    /**
     * Actualiza un ítem de pedido existente.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        // Valida los datos de actualización.
        $request->validate([
            'quantity' => 'sometimes|required|integer|min:1',
            'customizations' => 'nullable|json',
            'subtotal' => 'sometimes|required|numeric|min:0',
        ]);
        
        $orderItem->update($request->all());
        
        return response()->json($orderItem, 200);
    }

    /**
     * Elimina un ítem de pedido.
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        
        return response()->json(null, 204);
    }
}