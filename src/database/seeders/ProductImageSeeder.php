<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductImage::create([
            'product_id' => 1,
            'image_url' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 2,
            'image_url' => 'https://images.unsplash.com/photo-1743456056112-0739a6742135?q=80&w=822&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 3,
            'image_url' => 'images/products/kalkulus_steward.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 4,
            'image_url' => 'images/products/meja_lipat.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 5,
            'image_url' => 'https://images.unsplash.com/photo-1609561954579-f5d38cece8c4?q=80&w=871&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 6,
            'image_url' => 'https://images.unsplash.com/photo-1773904215704-139e9ff8c894?q=80&w=388&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 7,
            'image_url' => 'https://images.unsplash.com/photo-1661595676335-aa93ecbf4b42?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 8,
            'image_url' => 'images/products/struktur_data_java.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 9,
            'image_url' => 'https://images.unsplash.com/photo-1757256137041-0aab889db199?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 10,
            'image_url' => 'https://images.unsplash.com/photo-1584628805011-382667dc3229?q=80&w=881&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 11,
            'image_url' => 'https://images.unsplash.com/photo-1568392816241-44d223d4d490?q=80&w=435&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 12,
            'image_url' => 'images/products/cosmos.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 13,
            'image_url' => 'images/products/rak_plastik.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 14,
            'image_url' => 'images/products/setrika.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 15,
            'image_url' => 'images/products/almet.jpg',
            'order' => 1
        ]);
        
        ProductImage::create([
            'product_id' => 16,
            'image_url' => 'https://images.unsplash.com/photo-1680292783974-a9a336c10366?q=80&w=394&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 17,
            'image_url' => 'images/products/tas_ransel.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 18,
            'image_url' => 'https://plus.unsplash.com/premium_photo-1762780827682-51aa29e4f946?q=80&w=871&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 19,
            'image_url' => 'images/products/topi_uns.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 20,
            'image_url' => 'https://images.unsplash.com/photo-1564227050211-b6061acd4158?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 21,
            'image_url' => 'https://images.unsplash.com/photo-1648659125396-5bf148702e3d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 22,
            'image_url' => 'images/products/bola_futsal.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 23,
            'image_url' => 'https://images.unsplash.com/photo-1703925153100-43afda8b6506?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 24,
            'image_url' => 'https://images.unsplash.com/photo-1594007759138-855170ec8dc0?q=80&w=388&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 25,
            'image_url' => 'https://images.unsplash.com/photo-1599957885229-5bca2201d80b?q=80&w=869&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 26,
            'image_url' => 'https://images.unsplash.com/photo-1522338140262-f46f5913618a?q=80&w=388&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 27,
            'image_url' => 'images/products/catokan.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 28,
            'image_url' => 'https://plus.unsplash.com/premium_photo-1732730224529-32b1c78ad394?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 29,
            'image_url' => 'https://images.unsplash.com/photo-1677019758488-ca44c974ef62?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 30,
            'image_url' => 'https://images.unsplash.com/photo-1688578735427-994ecdea3ea4?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
    }
}
