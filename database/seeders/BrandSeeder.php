<?php
// database/seeders/BrandSeeder.php
namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            [
                'name' => 'TechGadget',
                'commission_rate' => '10%',
                'is_active' => true,
            ],
            [
                'name' => 'FashionHub',
                'commission_rate' => '15%',
                'is_active' => true,
            ],
            [
                'name' => 'HealthPlus',
                'commission_rate' => '12%',
                'is_active' => true,
            ],
            [
                'name' => 'HomeDecor',
                'commission_rate' => '8%',
                'is_active' => true,
            ],
            [
                'name' => 'BookWorld',
                'commission_rate' => '20%',
                'is_active' => true,
            ],
        ];
        
        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}