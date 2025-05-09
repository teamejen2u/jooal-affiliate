<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a default user for testing
        User::create([
            'name' => 'Alex Johnson',
            'email' => 'alex.johnson@example.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('password'),
            'level' => 'gold',
            'xp_points' => 825,
            'earnings' => 1245.80,
            'sales_count' => 128,
            'click_count' => 3841,
            'conversion_rate' => 3.3,
            'rank' => 42,
            'referral_code' => 'ALEXJ25',
            'joined_at' => now()->subMonths(2),
            'payment_method' => 'paypal',
        ]);
    }
}