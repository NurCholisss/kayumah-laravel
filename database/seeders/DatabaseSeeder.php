<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin KayUmah',
            'email' => 'admin@kayumah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin KayUmah No. 1',
        ]);

        // Create regular user
        User::create([
            'name' => 'Customer Example',
            'email' => 'customer@kayumah.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081234567891',
            'address' => 'Jl. Customer Example No. 2',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Kursi'],
            ['name' => 'Meja'],
            ['name' => 'Lemari'],
            ['name' => 'Sofa'],
            ['name' => 'Tempat Tidur'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Kursi Kayu Jati Modern',
                'description' => 'Kursi kayu jati dengan desain modern yang elegan dan nyaman.',
                'price' => 1250000,
                'stock' => 15,
                'main_image' => 'products/kursi-jati-modern.jpg',
            ],
            [
                'category_id' => 2,
                'name' => 'Meja Makan Minimalis',
                'description' => 'Meja makan minimalis dengan bahan kayu oak berkualitas tinggi.',
                'price' => 2850000,
                'stock' => 8,
                'main_image' => 'products/meja-makan-minimalis.jpg',
            ],
            [
                'category_id' => 3,
                'name' => 'Lemari Pakaian 3 Pintu',
                'description' => 'Lemari pakaian 3 pintu dengan rak yang luas dan desain modern.',
                'price' => 4500000,
                'stock' => 5,
                'main_image' => 'products/lemari-3-pintu.jpg',
            ],
            [
                'category_id' => 4,
                'name' => 'Sofa L Sudut Minimalis',
                'description' => 'Sofa L sudut dengan bahan kain premium dan bantal empuk.',
                'price' => 7500000,
                'stock' => 3,
                'main_image' => 'products/sofa-l-sudut.jpg',
            ],
            [
                'category_id' => 5,
                'name' => 'Tempat Tidur King Size',
                'description' => 'Tempat tidur king size dengan rangka kayu solid dan headboard empuk.',
                'price' => 8500000,
                'stock' => 4,
                'main_image' => 'products/tempat-tidur-king.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@kayumah.com / password');
        $this->command->info('Customer Login: customer@kayumah.com / password');
    }
}