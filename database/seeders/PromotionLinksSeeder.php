<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionLinksSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Promotion ID 2: Descuento $100 Producto -> productos 1 y 2
        $promo2 = Promotion::find(2);
        if ($promo2) {
            $promo2->products()->sync([1, 2]);
        }

        // Promotion ID 3: 20% OFF Producto -> productos 3 y 4
        $promo3 = Promotion::find(3);
        if ($promo3) {
            $promo3->products()->sync([3, 4]);
        }

        // Promotion ID 4: 15% OFF Categoría -> categoría 1 (Audio)
        $promo4 = Promotion::find(4);
        if ($promo4) {
            $promo4->categories()->sync([1]);
        }

        // Promotion ID 5: Super Black Friday 50% -> todas las categorías
        $promo5 = Promotion::find(5);
        if ($promo5) {
            $promo5->categories()->sync([1, 2]);
        }

        $this->command->info('Promotions linked to products and categories successfully!');
    }
}
