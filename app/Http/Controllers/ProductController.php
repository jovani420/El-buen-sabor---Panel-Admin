<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     */
    public function index()
    {
        // Devuelve todos los productos, precargando la categoría y los addons
        // para evitar problemas de N+1 queries.
        return Product::with(['category', 'addons'])->get();
    }

    /**
     * Almacena un nuevo producto.
     */
    public function store(Request $request)
    {
        // Valida la solicitud antes de crear.
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
        ]);
        
        $product = Product::create($request->all());
        
        // Si se proporcionan IDs de addons, asocia el producto con ellos.
        if ($request->has('addons')) {
            $product->addons()->sync($request->input('addons'));
        }
        
        return response()->json($product->load(['category', 'addons']), 201);
    }

    /**
     * Muestra un producto específico.
     */
    public function show(Product $product)
    {
        // Devuelve un producto específico, cargando sus relaciones.
        return $product->load(['category', 'addons']);
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(Request $request, Product $product)
    {
        // Valida los datos de actualización.
        $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
        ]);

        $product->update($request->all());

        // Si se proporcionan IDs de addons, sincroniza las relaciones.
        if ($request->has('addons')) {
            $product->addons()->sync($request->input('addons'));
        }
        
        return response()->json($product->load(['category', 'addons']), 200);
    }

    /**
     * Elimina un producto.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->json(null, 204);
    }
}