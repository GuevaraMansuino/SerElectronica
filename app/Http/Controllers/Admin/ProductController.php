<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

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
        $validated = $request->validated();

        // Guardar imagen principal
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validated['image'] = null;
        }

        // Quitar gallery_images del array antes de crear (no es columna de la tabla products)
        unset($validated['gallery_images']);

        $product = Product::create($validated);

        // Guardar imágenes de la galería (siempre es un INSERT, no UPDATE)
        if ($request->hasFile('gallery_images')) {
            $galleryOrder = 1;
            foreach ($request->file('gallery_images') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('products/gallery', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'order' => $galleryOrder++,
                        'is_primary' => false,
                    ]);
                }
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

    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($id);

        // Si hay nueva imagen, eliminar la anterior
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->has('eliminar_imagen') && $request->eliminar_imagen == '1') {
            // Eliminar imagen existente si se marcó para eliminar
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = null;
        }

        // Quitar gallery_images del array antes de actualizar
        unset($validated['gallery_images']);

        $product->update($validated);

        // Eliminar imágenes marcadas para borrar
        $deleteIds = $request->input('delete_images', []);
        $deleteIds = array_filter($deleteIds); // Remove empty values
        if (!empty($deleteIds)) {
            $imagesToDelete = $product->images()->whereIn('id', $deleteIds)->get();
            foreach ($imagesToDelete as $img) {
                if ($img->image_path) {
                    Storage::disk('public')->delete($img->image_path);
                }
            }
            $product->images()->whereIn('id', $deleteIds)->delete();
        }

        // Agregar nuevas imágenes a la galería (siempre es un INSERT)
        if ($request->hasFile('gallery_images')) {
            $currentMaxOrder = $product->images()->max('order') ?? 0;
            $galleryOrder = $currentMaxOrder + 1;
            
            foreach ($request->file('gallery_images') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('products/gallery', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'order' => $galleryOrder++,
                        'is_primary' => false,
                    ]);
                }
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
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
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
    
    /**
     * Eliminar imagen de la galería
     */
    public function deleteGalleryImage(string $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        
        return response()->json(['success' => true]);
    }
}
