<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$productosEnPromo = \App\Models\Product::where('is_active', true)
    ->where(function($productQuery) {
        $productQuery->whereHas('promotions', function($query) {
            $query->where('is_active', true)
                ->where(function($q) {
                    $q->whereDate('start_date', '<=', now())
                      ->orWhereNull('start_date')
                      ->orWhere('start_date', '');
                })
                ->where(function($q) {
                    $q->whereDate('end_date', '>=', now())
                      ->orWhereNull('end_date')
                      ->orWhere('end_date', '');
                });
        })
        ->orWhereHas('category.promotions', function($query) {
            $query->where('is_active', true)
                ->where(function($q) {
                    $q->whereDate('start_date', '<=', now())
                      ->orWhereNull('start_date')
                      ->orWhere('start_date', '');
                })
                ->where(function($q) {
                    $q->whereDate('end_date', '>=', now())
                      ->orWhereNull('end_date')
                      ->orWhere('end_date', '');
                });
        });
    })
    ->get();

echo "Total productos en promo: " . $productosEnPromo->count() . "\n";
