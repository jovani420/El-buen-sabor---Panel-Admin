<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Muestra una lista de las categorías.
     */
    public function index()
    {
        // Devuelve todas las categorías con sus productos relacionados.
        return Category::with('products')->get();
    }

    /**
     * Almacena una nueva categoría.
     */
    public function store(Request $request)
    {
        // Valida la solicitud antes de crear.
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories|max:255',
        ]);
        
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    /**
     * Muestra una categoría específica.
     */
    public function show(Category $category)
    {
        // Devuelve una categoría, cargando sus productos relacionados.
        return $category->load('products');
    }

    /**
     * Actualiza una categoría existente.
     */
    public function update(Request $request, Category $category)
    {
        // Valida la solicitud.
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:categories,slug,' . $category->id . '|max:255',
        ]);
        
        $category->update($request->all());
        return response()->json($category, 200);
    }

    /**
     * Elimina una categoría.
     */
    public function destroy(Category $category)
    {
        // La relación `onDelete('cascade')` en la migración de `products`
        // se encargará de eliminar los productos asociados.
        $category->delete();
        return response()->json(null, 204);
    }
}