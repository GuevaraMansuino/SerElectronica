<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = App\Models\Product::orderBy('id', 'desc')->take(15)->get();
foreach($products as $p) {
    echo $p->id . " - " . $p->name . "\n";
}
