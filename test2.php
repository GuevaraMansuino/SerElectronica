<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$promo = \App\Models\Promotion::first();
if ($promo) {
    if ($promo->products()->count() === 0 && $promo->categories()->count() === 0) {
        $p = \App\Models\Product::first();
        if ($p) {
            $promo->products()->syncWithoutDetaching([$p->id]);
            echo "Added product '{$p->name}' to promo '{$promo->title}'\n";
        }
    } else {
        echo "Promo already has products or categories.\n";
    }
}
