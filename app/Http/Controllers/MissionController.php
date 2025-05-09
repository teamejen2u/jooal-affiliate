<?php
// app/Http/Controllers/MissionController.php
namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $dailyMissions = $user->missions()
            ->where('type', 'daily')
            ->wherePivot('completed', false)
            ->get();
            
        $achievementMissions = $user->missions()
            ->where('type', 'achievement')
            ->orderByRaw('CASE WHEN pivot_completed = 0 THEN 0 ELSE 1 END')
            ->orderBy('reward_points', 'desc')
            ->get();
            
        return view('missions.index', compact('user', 'dailyMissions', 'achievementMissions'));
    }
    
    public function claimReward(Request $request, Mission $mission)
    {
        $user = Auth::user();
        $userMission = UserMission::where('user_id', $user->id)
            ->where('mission_id', $mission->id)
            ->where('completed', true)
            ->where('reward_claimed', false)
            ->first();
            
        if (!$userMission) {
            return redirect()->back()->with('error', 'Mission not completed or reward already claimed');
        }
        
        // Update user XP
        $user->xp_points += $mission->reward_points;
        $user->save();
        
        // Mark reward as claimed
        $userMission->reward_claimed = true;
        $userMission->save();
        
        return redirect()->back()->with('success', 'Reward claimed successfully');
    }
}