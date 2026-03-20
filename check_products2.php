<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = App\Models\Product::orderBy('id', 'desc')->take(215)->get();
$firstInBatch = array_slice(array_reverse($products->toArray()), 0, 10); 
foreach($firstInBatch as $p) {
    echo $p['id'] . " - " . $p['name'] . "\n";
}
