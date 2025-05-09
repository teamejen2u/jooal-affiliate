<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get top brands
        $brands = Brand::active()->take(5)->get();
        
        // Get active missions
        $missions = $user->missions()
            ->wherePivot('completed', false)
            ->orderBy('type')
            ->take(3)
            ->get();
            
        return view('dashboard.index', compact('user', 'brands', 'missions'));
    }
}