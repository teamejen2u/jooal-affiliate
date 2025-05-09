<?php
// database/seeders/RewardSeeder.php
namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    public function run()
    {
        $rewards = [
            [
                'title' => 'Bonus Tunai',
                'description' => 'Tebus bonus tunai RM25 yang akan dikreditkan ke akaun anda',
                'amount' => 'RM25',
                'icon' => '💰',
                'points_required' => 500,
                'is_available' => true,
            ],
            [
                'title' => 'Kad Hadiah Amazon',
                'description' => 'Tebus kad hadiah Amazon bernilai RM50',
                'amount' => 'RM50',
                'icon' => '🎁',
                'points_required' => 1000,
                'is_available' => true,
            ],
            [
                'title' => 'Akses Premium',
                'description' => 'Dapatkan akses ke ciri-ciri premium selama 1 bulan',
                'amount' => '1 Bulan',
                'icon' => '⭐',
                'points_required' => 1500,
                'is_available' => false,
            ],
            [
                'title' => 'Sorotan Istimewa',
                'description' => 'Pautan affiliate anda akan ditonjolkan di laman utama',
                'amount' => 'Laman Utama',
                'icon' => '🔍',
                'points_required' => 2000,
                'is_available' => false,
            ],
        ];
        
        foreach ($rewards as $reward) {
            Reward::create($reward);
        }
    }
}