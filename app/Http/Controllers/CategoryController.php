<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categorias = Category::with('items')->get();

        return response()->json($categorias);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria' => 'required|string|max:255',
            'codigo' => 'required|string|max:100|unique:categories,codigo',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Categoría creada correctamente.',
            'categoria' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::with('items')->findOrFail($id);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'categoria' => 'required|string|max:255',
            'codigo' => 'required|string|max:100|unique:categories,codigo,' . $category->id,
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Categoría actualizada correctamente.',
            'categoria' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente.'
        ]);
    }
}