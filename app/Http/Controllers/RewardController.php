<?php
// app/Http/Controllers/RewardController.php
namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rewards = Reward::all();
        
        return view('rewards.index', compact('user', 'rewards'));
    }
    
    public function redeem(Request $request, Reward $reward)
    {
        $user = Auth::user();
        
        if (!$reward->is_available) {
            return redirect()->back()->with('error', 'This reward is not available');
        }
        
        if ($user->xp_points < $reward->points_required) {
            return redirect()->back()->with('error', 'Not enough points to redeem this reward');
        }
        
        // Deduct points
        $user->xp_points -= $reward->points_required;
        $user->save();
        
        // In a real app, you would handle the reward delivery logic here
        
        return redirect()->back()->with('success', 'Reward redeemed successfully');
    }
}