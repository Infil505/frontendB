<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\StoreItemRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index(Category $category, Request $request)
    {
        $query = Item::with('category')->where('category_id', $category->id);

        if ($request->has('tipo')) {
            $query->where('type', $request->tipo);
        }

        $items = $query->get();

        return response()->json($items);
    }


    // Listar todos los ítems (sin importar categoría)
    public function all()
    {
        $items = Item::with('category')->paginate(10);

        return response()->json([
            'items' => $items
        ]);
    }

    // Crear un ítem
    public function store(StoreItemRequest $request)
    {

        $validated = $request->validated();

        $finalPrice = $validated['price'] * (1 - $validated['discount'] / 100);

        $item = Item::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'type' => $validated['type'],
            'short_description' => $validated['name'],
            'stock' => $validated['stock'],
            'price' => $validated['price'],
            'discount' => $validated['discount'],
            'category_id' => $validated['category_id'],
            'final_price' => $finalPrice,
        ]);

        return response()->json([
            'message' => 'Ítem creado correctamente.',
            'item' => $item
        ], 201);
    }


    public function search(Request $request)
    {
        $q = $request->input('q');

        $items = Item::with('category')
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            })
            ->get();

        return response()->json($items);
    }

    // Mostrar un ítem específico
    public function show(Item $item)
    {
        $item->load('category');

        return response()->json($item);
    }

    // Actualizar un ítem
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'type' => 'required',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['final_price'] = $validated['price'] * (1 - $validated['discount'] / 100);

        $item->update($validated);

        return response()->json([
            'message' => 'Ítem actualizado correctamente.',
            'item' => $item
        ]);
    }


    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Ítem no encontrado'], 404);
        }

        $deletedItem = $item->toArray(); // Guardamos los datos antes de eliminar
        $item->delete();

        return response()->json([
            'message' => 'Ítem eliminado correctamente',
            'item' => $deletedItem
        ]);
    }


}
