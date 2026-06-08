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
        // Smartphone Samsung A12
        ProductImage::create([
            'product_id' => 5,
            'image_url' => 'https://images.unsplash.com/photo-1609561954579-f5d38cece8c4?q=80&w=871&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 5,
            'image_url' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?q=80&w=800&auto=format&fit=crop',
            'order' => 2
        ]);

        ProductImage::create([
            'product_id' => 5,
            'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800&auto=format&fit=crop',
            'order' => 3
        ]);

        ProductImage::create([
            'product_id' => 5,
            'image_url' => 'https://images.unsplash.com/photo-1567581935884-3349723552ca?q=80&w=800&auto=format&fit=crop',
            'order' => 4
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

        // Kipas Angin Miyako
        ProductImage::create([
            'product_id' => 11,
            'image_url' => 'images/products/kipas_miyako.jpg',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 11,
            'image_url' => 'images/products/kipas_miyako2.jpg',
            'order' => 2
        ]);

        ProductImage::create([
            'product_id' => 11,
            'image_url' => 'images/products/kipas_miyako3.jpg',
            'order' => 3
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

        // Board Game Monopoly
        ProductImage::create([
            'product_id' => 23,
            'image_url' => 'https://images.unsplash.com/photo-1703925153100-43afda8b6506?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 23,
            'image_url' => 'https://images.unsplash.com/photo-1703248184387-f6b2cbe1c981?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 2
        ]);

        ProductImage::create([
            'product_id' => 23,
            'image_url' => 'https://images.unsplash.com/photo-1640461470346-c8b56497850a?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 3
        ]);

        ProductImage::create([
            'product_id' => 23,
            'image_url' => 'https://images.unsplash.com/photo-1640461470346-c8b56497850a?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 4
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

        // Hair Dryer Philips
        ProductImage::create([
            'product_id' => 26,
            'image_url' => 'https://images.unsplash.com/photo-1522338140262-f46f5913618a?q=80&w=388&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);
        ProductImage::create([
            'product_id' => 26,
            'image_url' => 'https://images.unsplash.com/photo-1522336284037-91f7da073525?q=80&w=869&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 2
        ]);

        ProductImage::create([
            'product_id' => 26,
            'image_url' => 'https://images.unsplash.com/photo-1540544093-65429dcbec50?q=80&w=899&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 3
        ]);

        ProductImage::create([
            'product_id' => 26,
            'image_url' => 'https://images.unsplash.com/photo-1540544093-f8803cbd9c64?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 4
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

        ProductImage::create([
            'product_id' => 31,
            'image_url' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?q=80&w=800&auto=format&fit=crop',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 31,
            'image_url' => 'https://plus.unsplash.com/premium_photo-1760531797838-2766def2f6f4?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 2
        ]);

        // Keyboard Mechanical Fantech
        ProductImage::create([
            'product_id' => 32,
            'image_url' => 'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?q=80&w=800&auto=format&fit=crop',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 32,
            'image_url' => 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?q=80&w=800&auto=format&fit=crop',
            'order' => 2
        ]);

        // Buku Basis Data
        ProductImage::create([
            'product_id' => 33,
            'image_url' => 'images/products/basis_data.jpg',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 33,
            'image_url' => 'images/products/basis_data2.jpg',
            'order' => 2
        ]);

        // Jaket Denim Biru
        ProductImage::create([
            'product_id' => 34,
            'image_url' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=800&auto=format&fit=crop',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 34,
            'image_url' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=800&auto=format&fit=crop',
            'order' => 2
        ]);

        // Dispenser Air Mini
        ProductImage::create([
            'product_id' => 35,
            'image_url' => 'images/products/dispenser.jpg',
            'order' => 1
        ]);

        // Matras Yoga
        ProductImage::create([
            'product_id' => 36,
            'image_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=800&auto=format&fit=crop',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 36,
            'image_url' => 'https://plus.unsplash.com/premium_photo-1667250493220-d154cebdfc68?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 2
        ]);

        // UNO Card Game
        ProductImage::create([
            'product_id' => 37,
            'image_url' => 'https://images.unsplash.com/photo-1633285505120-5144276a0757?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        // Cermin Berdiri
        ProductImage::create([
            'product_id' => 38,
            'image_url' => 'https://images.unsplash.com/photo-1598116132066-b730a4f8616a?q=80&w=435&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 38,
            'image_url' => 'https://images.unsplash.com/photo-1667610342763-7618517d9651?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 2
        ]);

        // Organizer Kosmetik
        ProductImage::create([
            'product_id' => 39,
            'image_url' => 'https://images.unsplash.com/photo-1617220379475-420f5a8a20d9?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 39,
            'image_url' => 'https://images.unsplash.com/photo-1631237535386-a771aa9fe527?q=80&w=725&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'order' => 2
        ]);

        // Ukulele Concert
        ProductImage::create([
            'product_id' => 40,
            'image_url' => 'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?q=80&w=800&auto=format&fit=crop',
            'order' => 1
        ]);

        ProductImage::create([
            'product_id' => 40,
            'image_url' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?q=80&w=800&auto=format&fit=crop',
            'order' => 2
        ]);
    }
}
