<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Handle image upload
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,webp|max:2048'
        ]);

        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image file provided'], 422);
        }

        $file = $request->file('image');

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $filename . '_' . time() . '.' . $extension;

        // Create directory if not exists
        $directory = public_path('storage/products');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        try {
            // Save the file
            $file->move($directory, $filename);

            return response()->json([
                'success' => true,
                'filename' => $filename,
                'path' => 'products/' . $filename,
                'url' => asset('storage/products/' . $filename)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error saving image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete image
     */
    public function delete(Request $request)
    {
        $filename = $request->input('filename');

        if (!$filename) {
            return response()->json(['error' => 'No filename provided'], 422);
        }

        $path = public_path('storage/products/' . $filename);

        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
