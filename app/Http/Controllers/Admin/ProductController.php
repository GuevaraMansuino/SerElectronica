<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\ImageTrait;
use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $productos = Product::with('category', 'promotions')->latest()->paginate(15);
        $categorias = Category::all();
        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Category::all();
        $promociones = Promotion::where('is_active', true)->get();
        return view('admin.productos.create', compact('categorias', 'promociones'));
    }

    public function store(StoreProductRequest $request)
    {
        // Map Spanish field names to English
        $data = $request->all();
        $map = [
            'nombre' => 'name',
            'categoria_id' => 'category_id',
            'precio' => 'price',
            'descripcion' => 'description',
        ];
        foreach ($map as $es => $en) {
            if (isset($data[$es])) {
                $data[$en] = $data[$es];
                unset($data[$es]);
            }
        }
        
        // Validate with mapped data
        $validated = validator($data, [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'slug' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'marca' => 'sometimes|string',
            'modelo' => 'sometimes|string',
            'destacado' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ])->validate();

        // Guardar imagen principal
        $validated['image'] = $this->saveImage($request, 'image');

        $product = Product::create($validated);

        // Guardar imágenes de la galería (siempre es un INSERT, no UPDATE)
        $galleryFiles = $request->file('gallery_images');
        
        if ($galleryFiles) {
            $fileCount = is_array($galleryFiles) ? count($galleryFiles) : 1;
            
            // También verificar si viene como array
            if (is_array($galleryFiles)) {
                foreach ($galleryFiles as $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store('products/gallery', 'public');
                        $product->images()->create([
                            'image_path' => $path,
                            'order' => $galleryOrder++,
                            'is_primary' => false,
                        ]);
                    }
                }
            } elseif ($galleryFiles->isValid()) {
                // Es un solo archivo
                $path = $galleryFiles->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'order' => 0,
                    'is_primary' => false,
                ]);
            }
        }

        // Asignar promociones
        if ($request->has('promociones')) {
            $product->promotions()->sync($request->promociones);
        }

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente');
    }

    public function edit(string $id)
    {
        $producto = Product::with('images', 'promotions')->findOrFail($id);
        $categorias = Category::all();
        $promociones = Promotion::where('is_active', true)->get();
        return view('admin.productos.edit', compact('producto', 'categorias', 'promociones'));
    }

    public function update(Request $request, string $id)
    {
        // Map Spanish field names to English
        $data = $request->all();
        $map = [
            'nombre' => 'name',
            'categoria_id' => 'category_id',
            'precio' => 'price',
            'descripcion' => 'description',
        ];
        foreach ($map as $es => $en) {
            if (isset($data[$es])) {
                $data[$en] = $data[$es];
                unset($data[$es]);
            }
        }
        
        // Validate with mapped data
        $validated = validator($data, [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'slug' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'destacado' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ])->validate();

        $product = Product::findOrFail($id);

        // Si hay nueva imagen, eliminar la anterior
        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $validated['image'] = $this->saveImage($request, 'image');
        } elseif ($request->has('image') && $request->image !== $product->image) {
            $this->deleteImage($product->image);
            $validated['image'] = $request->image;
        }

        $product->update($validated);

        // Eliminar imágenes marcadas para borrar
        $deleteIds = $request->input('delete_images', []);
        $deleteIds = array_filter($deleteIds); // Remove empty values
        if (!empty($deleteIds)) {
            $imagesToDelete = $product->images()->whereIn('id', $deleteIds)->get();
            foreach ($imagesToDelete as $img) {
                $this->deleteImage($img->image_path);
            }
            $product->images()->whereIn('id', $deleteIds)->delete();
        }

        // Agregar nuevas imágenes a la galería (siempre es un INSERT)
        $galleryFiles = $request->file('gallery_images');
        if ($galleryFiles) {
            $currentMaxOrder = $product->images()->max('order') ?? 0;
            $galleryOrder = $currentMaxOrder + 1;
            
            if (is_array($galleryFiles)) {
                foreach ($galleryFiles as $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store('products/gallery', 'public');
                        $product->images()->create([
                            'image_path' => $path,
                            'order' => $galleryOrder++,
                            'is_primary' => false,
                        ]);
                    }
                }
            } elseif ($galleryFiles->isValid()) {
                // Es un solo archivo
                $path = $galleryFiles->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'order' => $galleryOrder,
                    'is_primary' => false,
                ]);
            }
        }

        // Sincronizar promociones
        if ($request->has('promociones')) {
            $product->promotions()->sync($request->promociones);
        } else {
            $product->promotions()->sync([]);
        }

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Eliminar imagen
        $this->deleteImage($product->image);
        
        $product->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente');
    }

    public function toggle(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success', 'Estado actualizado');
    }
}
