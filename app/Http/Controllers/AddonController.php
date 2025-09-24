<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Product; // Importa el modelo Product si vas a manejar las relaciones
use Illuminate\Http\Request;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Devuelve todos los addons. Usar with('products') para incluir la relación.
        return Addon::with('products')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Crea un nuevo addon.
        $addon = Addon::create($request->all());

        // Si se proporcionan IDs de productos, asocia el addon con ellos.
        if ($request->has('products')) {
            $addon->products()->sync($request->input('products'));
        }

        return response()->json($addon->load('products'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Addon $addon)
    {
        // Devuelve un addon específico, incluyendo los productos relacionados.
        return $addon->load('products');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addon $addon)
    {
        // Actualiza el addon.
        $addon->update($request->all());

        // Si se proporcionan IDs de productos, sincroniza las relaciones.
        if ($request->has('products')) {
            $addon->products()->sync($request->input('products'));
        }

        return response()->json($addon->load('products'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addon $addon)
    {
        // Elimina el addon. La relación se gestiona automáticamente por la migración.
        $addon->delete();

        return response()->json(null, 204);
    }
}