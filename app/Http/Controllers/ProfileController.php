<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('profile.index', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'payment_method' => 'nullable|string|max:255',
            'profile_pic' => 'nullable|image|max:1024',
        ]);
        
        $data = $request->only(['name', 'email', 'payment_method']);
        
        if ($request->hasFile('profile_pic')) {
            // Delete old profile pic if exists
            if ($user->profile_pic && Storage::exists('public/profiles/' . $user->profile_pic)) {
                Storage::delete('public/profiles/' . $user->profile_pic);
            }
            
            // Store new profile pic
            $profilePic = $request->file('profile_pic');
            $filename = $user->id . '_' . time() . '.' . $profilePic->getClientOriginalExtension();
            $profilePic->storeAs('public/profiles', $filename);
            
            $data['profile_pic'] = $filename;
        }
        
        $user->update($data);
        
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}