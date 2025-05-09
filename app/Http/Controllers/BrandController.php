<?php
// app/Http/Controllers/BrandController.php
namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $brands = Brand::active()->get();
        
        return view('brands.index', compact('user', 'brands'));
    }
    
    public function generateLink(Request $request, Brand $brand)
    {
        $user = Auth::user();
        
        // Check if link already exists
        $affiliateLink = AffiliateLink::where('user_id', $user->id)
            ->where('brand_id', $brand->id)
            ->first();
            
        if (!$affiliateLink) {
            // Create new link
            $affiliateLink = AffiliateLink::create([
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'link_code' => $user->referral_code . '-' . Str::random(8),
            ]);
        }
        
        $linkUrl = route('affiliate.redirect', $affiliateLink->link_code);
        
        return response()->json([
            'success' => true,
            'link' => $linkUrl,
        ]);
    }
}