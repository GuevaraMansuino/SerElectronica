<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Mostrar página de importación de categorías
     */
    public function showImportCategories()
    {
        return view('admin.categorias.import');
    }

    /**
     * Mostrar página de importación de productos
     */
    public function showImportProducts()
    {
        $categorias = Category::all();
        return view('admin.productos.import', compact('categorias'));
    }

    /**
     * Importar categorías desde archivo
     */
    public function importCategories(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:text/csv,text/plain,application/csv,application/excel,application/vnd.ms-excel'
        ]);

        try {
            $file = fopen($request->file('file')->getRealPath(), 'r');
            
            // Leer encabezados
            $headers = fgetcsv($file, 1000, ';');
            
            // Normalizar encabezados (minúsculas, sin espacios)
            $headers = array_map(function($h) {
                return trim(strtolower($h));
            }, $headers);

            $imported = 0;
            $errors = [];

            while (($row = fgetcsv($file, 1000, ';')) !== FALSE) {
                $data = array_combine($headers, $row);
                
                if (empty($data['name'])) {
                    $errors[] = 'Fila sin nombre, saltada';
                    continue;
                }

                // Generar slug si no existe
                $slug = isset($data['slug']) && !empty($data['slug']) 
                    ? $data['slug'] 
                    : Str::slug($data['name']);
                
                // Asegurar slug único
                $originalSlug = $slug;
                $counter = 1;
                while (Category::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                Category::create([
                    'name' => $data['name'],
                    'slug' => $slug,
                    'description' => $data['description'] ?? null,
                    'icono_emoji' => $data['icono_emoji'] ?? '📦',
                ]);

                $imported++;
            }

            fclose($file);

            return redirect()->route('admin.categorias.index')
                ->with('success', "{$imported} categorías importadas correctamente");
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    /**
     * Importar productos desde archivo
     */
    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:text/csv,text/plain,application/csv,application/excel,application/vnd.ms-excel'
        ]);

        try {
            $file = fopen($request->file('file')->getRealPath(), 'r');
            
            // Leer encabezados
            $headers = fgetcsv($file, 1000, ';');
            
            // Normalizar encabezados
            $headers = array_map(function($h) {
                return trim(strtolower($h));
            }, $headers);

            $imported = 0;
            $errors = [];

            while (($row = fgetcsv($file, 1000, ';')) !== FALSE) {
                $data = array_combine($headers, $row);
                
                if (empty($data['name'])) {
                    $errors[] = 'Fila sin nombre, saltada';
                    continue;
                }

                // Validar que category_id existe
                $categoryId = $data['category_id'] ?? 1;
                if (!Category::where('id', $categoryId)->exists()) {
                    $errors[] = "Categoría ID {$categoryId} no existe, usando 1";
                    $categoryId = 1;
                }

                // Generar slug si no existe
                $slug = isset($data['slug']) && !empty($data['slug']) 
                    ? $data['slug'] 
                    : Str::slug($data['name']);
                
                // Asegurar slug único
                $originalSlug = $slug;
                $counter = 1;
                while (Product::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                // Crear producto
                $product = Product::create([
                    'name' => $data['name'],
                    'slug' => $slug,
                    'description' => $data['description'] ?? null,
                    'price' => floatval($data['price'] ?? 0),
                    'category_id' => $categoryId,
                    'marca' => $data['marca'] ?? null,
                    'modelo' => $data['modelo'] ?? null,
                    'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true,
                    'is_new' => isset($data['is_new']) ? (bool)$data['is_new'] : false,
                    'destacado' => isset($data['destacado']) ? (bool)$data['destacado'] : false,
                    'image' => $data['image'] ?? null,
                ]);

                // Procesar galería de imágenes (separadas por coma)
                if (!empty($data['gallery'])) {
                    $galleryImages = explode(',', $data['gallery']);
                    $order = 1;
                    foreach ($galleryImages as $imagePath) {
                        $imagePath = trim($imagePath);
                        if (!empty($imagePath)) {
                            $product->images()->create([
                                'image_path' => $imagePath,
                                'order' => $order++,
                                'is_primary' => false,
                            ]);
                        }
                    }
                }

                $imported++;
            }

            fclose($file);

            return redirect()->route('admin.productos.index')
                ->with('success', "{$imported} productos importados correctamente");
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }
}
