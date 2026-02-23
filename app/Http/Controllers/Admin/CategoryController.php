<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categorias = Category::withCount('products')->latest()->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create', ['categoria' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Mapear 'nombre' (del formulario) a 'name' (de la base de datos)
        if (isset($data['nombre'])) {
            $data['name'] = $data['nombre'];
        }

        // Generar slug automáticamente si no viene (caso create)
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icono_emoji' => 'nullable|string|max:10',
        ])->validate();

        Category::create($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente');
    }

    public function show(string $id)
    {
        $categoria = Category::with('products')->findOrFail($id);
        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(string $id)
    {
        $categoria = Category::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, string $id)
    {
        $categoria = Category::findOrFail($id);
        $data = $request->all();

        // Mapear 'nombre' a 'name'
        if (isset($data['nombre'])) {
            $data['name'] = $data['nombre'];
        }

        // Generar slug automáticamente al actualizar el nombre
        if (!empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $categoria->id,
            'description' => 'nullable|string',
            'icono_emoji' => 'nullable|string|max:10',
        ])->validate();

        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(string $id)
    {
        $categoria = Category::findOrFail($id);
        
        // Check if category has products
        if ($categoria->products()->count() > 0) {
            return redirect()->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar una categoría con productos asociados');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente');
    }
}
