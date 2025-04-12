<?php




namespace App\Http\Controllers;

abstract class Controller
{
    public function updatePhoto(Request $request, User $user)
    {
            // Check if logged-in user is the same as target user
        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $request->validate([
            'photo' => 'required|image|max:2048',  // only images, max 2MB
        ]);
    
        if ($request->hasFile('photo')) {
            // Save to storage/app/public/users
            $path = $request->file('photo')->store('users', 'public');
    
            // Save URL to database
            $user->photo = '/storage/' . $path;
            $user->save();
    
            return response()->json([
                'message' => 'Photo uploaded successfully.',
                'photo_url' => $user->photo,
            ]);
        }
    
        return response()->json(['message' => 'No photo uploaded.'], 400);
    }
    
}
