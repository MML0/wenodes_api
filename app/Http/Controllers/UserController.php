<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;


abstract class Controller
{
    public function updatePhoto(Request $request, User $user)
    {
        $key = 'user_photo_upload_' . $user->id; // Define the key for rate limiting
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($key, 600); // 10 minutes in seconds

        // Check if logged-in user is the same as target user
        if ($request->user()->id !== $user->id && $request->user()->type !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        
        $request->validate([
            'photo' => 'required|image|max:2048',  // only images, max 2MB
        ]);
    
        // Check if the request contains a file named 'photo'
        if ($request->hasFile('photo')) {
            // Generate a unique filename for the uploaded photo
            $filename = uniqid('user_' . $user->id . '_') . '.' . $request->file('photo')->getClientOriginalExtension();
            // Store the photo in the 'users' directory within the public storage
            $path = $request->file('photo')->storeAs('users', $filename, 'public');
    
            // Update the user's photo attribute with the URL of the uploaded photo
            $user->photo = '/storage/' . $path;
            // Save the updated user model to the database
            $user->save();
    
            // Return a JSON response indicating success and the URL of the uploaded photo
            return response()->json([
                'message' => 'Photo uploaded successfully.',
                'photo_url' => $user->photo,
            ]);
        }
    
        return response()->json(['message' => 'No photo uploaded.'], 400);
    }
    
}
