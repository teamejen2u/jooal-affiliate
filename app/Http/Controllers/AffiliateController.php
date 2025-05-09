<?php
// app/Http/Controllers/AffiliateController.php
namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function redirect($linkCode)
    {
        $affiliateLink = AffiliateLink::where('link_code', $linkCode)->first();
        
        if (!$affiliateLink) {
            return redirect('/');
        }
        
        // Increment click count
        $affiliateLink->clicks += 1;
        $affiliateLink->save();
        
        // Update user click count
        $user = $affiliateLink->user;
        $user->click_count += 1;
        $user->save();
        
        // Update share link mission if exists
        $shareLinkMission = Mission::where('title', 'like', 'Kongsi % pautan affiliate')->first();
        if ($shareLinkMission) {
            $userMission = UserMission::firstOrCreate(
                ['user_id' => $user->id, 'mission_id' => $shareLinkMission->id],
                ['progress' => 0]
            );
            
            if (!$userMission->completed) {
                $userMission->progress += 1;
                
                if ($userMission->progress >= $shareLinkMission->target_value) {
                    $userMission->completed = true;
                }
                
                $userMission->save();
            }
        }
        
        // In a real app, you would redirect to the actual brand URL with tracking
        // For now, redirect to the brand's website
        return redirect('https://' . $affiliateLink->brand->name . '.example.com');
    }
}