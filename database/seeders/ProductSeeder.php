<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name'       => 'Produk A',
                'detail'     => 'Deskripsi lengkap produk A.',
                'price'      => 150000.00,
                'stock'      => 20,
                'image'      => 'https://i5.walmartimages.com/seo/L-Oreal-Paris-Elvive-Hyaluron-Plump-Hydrating-Shampoo-with-Hyaluronic-Acid-12-6-fl-oz_26a53537-9226-437c-966c-259bcb4c313a.4b200692e741baab8f12a6163aaf435c.png', 
                'is_active'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Produk B',
                'detail'     => 'Deskripsi lengkap produk B.',
                'price'      => 250000.00,
                'stock'      => 10,
                'image'      => 'https://hips.hearstapps.com/vader-prod.s3.amazonaws.com/1680182932-l-oreal-elvive-clay-shampoo-64258e8283a72.png', 
                'is_active'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Produk C',
                'detail'     => 'Deskripsi lengkap produk C.',
                'price'      => 99000.00,
                'stock'      => 35,
                'image'      => 'https://dm.henkel-dam.com/is/image/henkel/EC-Oil-Nutritive-Shampoo-400mL?scl=1&fmt=png-alpha', 
                'is_active'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
