<?php
// database/seeders/MissionSeeder.php
namespace Database\Seeders;

use App\Models\Mission;
use App\Models\User;
use App\Models\UserMission;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    public function run()
    {
        // Create missions
        $missions = [
            [
                'title' => 'Kongsi 5 pautan affiliate',
                'description' => 'Kongsikan 5 pautan affiliate dengan rakan-rakan anda',
                'type' => 'achievement',
                'target_value' => 5,
                'reward_points' => 50,
            ],
            [
                'title' => 'Lengkapkan profil',
                'description' => 'Tambahkan gambar profil dan info peribadi anda',
                'type' => 'achievement',
                'target_value' => 1,
                'reward_points' => 100,
            ],
            [
                'title' => 'Hasilkan jualan pertama',
                'description' => 'Dapatkan jualan pertama anda melalui pautan affiliate',
                'type' => 'achievement',
                'target_value' => 1,
                'reward_points' => 200,
            ],
            [
                'title' => 'Capai kadar penukaran 3%',
                'description' => 'Mencapai kadar penukaran sekurang-kurangnya 3%',
                'type' => 'achievement',
                'target_value' => 3,
                'reward_points' => 300,
            ],
            [
                'title' => 'Capai jualan RM1000',
                'description' => 'Hasilkan jualan bernilai RM1000',
                'type' => 'achievement',
                'target_value' => 1000,
                'reward_points' => 500,
            ],
            [
                'title' => 'Kongsi 2 pautan affiliate hari ini',
                'description' => 'Kongsikan 2 pautan affiliate dengan rakan-rakan anda hari ini',
                'type' => 'daily',
                'target_value' => 2,
                'reward_points' => 25,
                'expires_at' => now()->endOfDay(),
            ],
            [
                'title' => 'Log masuk ke dashboard',
                'description' => 'Log masuk ke dashboard affiliate anda',
                'type' => 'daily',
                'target_value' => 1,
                'reward_points' => 10,
                'expires_at' => now()->endOfDay(),
            ],
        ];
        
        foreach ($missions as $mission) {
            Mission::create($mission);
        }
        
        // Assign missions to default user
        $user = User::first();
        
        // Assign achievement missions with progress
        $achievementMissions = Mission::achievement()->get();
        foreach ($achievementMissions as $mission) {
            $completed = false;
            $progress = 0;
            
            // Set progress and completed status based on mission
            if ($mission->title == 'Kongsi 5 pautan affiliate') {
                $progress = 3;
            } elseif ($mission->title == 'Lengkapkan profil') {
                $progress = 1;
                $completed = true;
            } elseif ($mission->title == 'Hasilkan jualan pertama') {
                $progress = 1;
                $completed = true;
            } elseif ($mission->title == 'Capai kadar penukaran 3%') {
                $progress = 3.3;
                $completed = true;
            } elseif ($mission->title == 'Capai jualan RM1000') {
                $progress = 1245.8;
                $completed = true;
            }
            
            UserMission::create([
                'user_id' => $user->id,
                'mission_id' => $mission->id,
                'progress' => $progress,
                'completed' => $completed,
                'reward_claimed' => false,
            ]);
        }
        
        // Assign daily missions
        $dailyMissions = Mission::daily()->get();
        foreach ($dailyMissions as $mission) {
            $completed = false;
            $progress = 0;
            
            // Set progress and completed status based on mission
            if ($mission->title == 'Log masuk ke dashboard') {
                $progress = 1;
                $completed = true;
            } elseif ($mission->title == 'Kongsi 2 pautan affiliate hari ini') {
                $progress = 1;
            }
            
            UserMission::create([
                'user_id' => $user->id,
                'mission_id' => $mission->id,
                'progress' => $progress,
                'completed' => $completed,
                'reward_claimed' => $completed,
            ]);
        }
    }
}