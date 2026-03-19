<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

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
     * Importar categorías desde archivo CSV o Excel (.xlsx / .xls)
     *
     * Columnas esperadas (primera fila = encabezados):
     * name, slug (opcional), description (opcional), icono_emoji (opcional)
     */
    public function importCategories(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ], [
            'file.mimes' => 'El archivo debe ser CSV (.csv) o Excel (.xlsx, .xls)',
        ]);

        try {
            $importer = new CategoriesImporter();
            Excel::import($importer, $request->file('file'));

            $imported = $importer->imported;
            $errors   = $importer->errors;

            $msg = "{$imported} categoría(s) importada(s) correctamente.";
            if (count($errors)) {
                $msg .= ' Advertencias: ' . implode('; ', array_slice($errors, 0, 5));
            }

            return redirect()->route('admin.categorias.index')->with('success', $msg);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    /**
     * Importar productos desde archivo CSV o Excel (.xlsx / .xls)
     *
     * Columnas esperadas (primera fila = encabezados):
     * name, slug (opcional), description (opcional), price, category_id,
     * marca (opcional), modelo (opcional), is_active (opcional, 1/0),
     * is_new (opcional, 1/0), destacado (opcional, 1/0),
     * image (opcional, URL), gallery (opcional, URLs separadas por coma)
     */
    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ], [
            'file.mimes' => 'El archivo debe ser CSV (.csv) o Excel (.xlsx, .xls)',
        ]);

        try {
            $importer = new ProductsImporter();
            Excel::import($importer, $request->file('file'));

            $imported = $importer->imported;
            $errors   = $importer->errors;

            $msg = "{$imported} producto(s) importado(s) correctamente.";
            if (count($errors)) {
                $msg .= ' Advertencias: ' . implode('; ', array_slice($errors, 0, 5));
            }

            return redirect()->route('admin.productos.index')->with('success', $msg);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Import helper: Categorías
// ─────────────────────────────────────────────────────────────────────────────

class CategoriesImporter implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public array $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            // Normalizar claves (trim + lowercase)
            $data = array_combine(
                array_map(fn($k) => trim(strtolower($k)), array_keys($data)),
                array_values($data)
            );

            if (empty($data['name'])) {
                $this->errors[] = 'Fila sin nombre, saltada';
                continue;
            }

            // Slug único
            $slug = !empty($data['slug'])
                ? Str::slug($data['slug'])
                : Str::slug($data['name']);

            $originalSlug = $slug;
            $counter = 1;
            while (Category::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            Category::create([
                'name'        => trim($data['name']),
                'slug'        => $slug,
                'description' => isset($data['description']) ? trim($data['description']) : null,
                'icono_emoji' => !empty($data['icono_emoji']) ? trim($data['icono_emoji']) : '📦',
            ]);

            $this->imported++;
        }
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Import helper: Productos
// ─────────────────────────────────────────────────────────────────────────────

class ProductsImporter implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public array $errors = [];

    /** Convierte valores tipo "1", "true", "si", "yes" → true */
    private function toBool(mixed $value): bool
    {
        if (is_bool($value)) return $value;
        return in_array(strtolower(trim((string) $value)), ['1', 'true', 'si', 'sí', 'yes'], true);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            // Normalizar claves
            $data = array_combine(
                array_map(fn($k) => trim(strtolower($k)), array_keys($data)),
                array_values($data)
            );

            if (empty($data['name'])) {
                $this->errors[] = 'Fila sin nombre, saltada';
                continue;
            }

            // Validar categoría
            $categoryId = isset($data['category_id']) && is_numeric($data['category_id'])
                ? (int) $data['category_id']
                : 1;

            if (!Category::where('id', $categoryId)->exists()) {
                $this->errors[] = "Categoría ID {$categoryId} no existe, usando 1";
                $categoryId = 1;
            }

            // Slug único
            $slug = !empty($data['slug'])
                ? Str::slug($data['slug'])
                : Str::slug($data['name']);

            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            // Crear producto
            $product = Product::create([
                'name'        => trim($data['name']),
                'slug'        => $slug,
                'description' => isset($data['description']) ? trim($data['description']) : null,
                'price'       => isset($data['price']) ? floatval($data['price']) : 0,
                'category_id' => $categoryId,
                'marca'       => isset($data['marca'])   ? trim($data['marca'])   : null,
                'modelo'      => isset($data['modelo'])  ? trim($data['modelo'])  : null,
                'is_active'   => isset($data['is_active'])  ? $this->toBool($data['is_active'])  : true,
                'is_new'      => isset($data['is_new'])     ? $this->toBool($data['is_new'])     : false,
                'destacado'   => isset($data['destacado'])  ? $this->toBool($data['destacado'])  : false,
                'image'       => isset($data['image'])   ? trim($data['image'])   : null,
            ]);

            // Galería (URLs separadas por coma)
            if (!empty($data['gallery'])) {
                $galleryImages = explode(',', $data['gallery']);
                $order = 1;
                foreach ($galleryImages as $imagePath) {
                    $imagePath = trim($imagePath);
                    if (!empty($imagePath)) {
                        $product->images()->create([
                            'image_path' => $imagePath,
                            'order'      => $order++,
                            'is_primary' => false,
                        ]);
                    }
                }
            }

            $this->imported++;
        }
    }
}
