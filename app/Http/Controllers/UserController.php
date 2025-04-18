<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;


class UserController extends Controller
{
    public function updatePhoto(Request $request, User $user = null)
    {
        $key = 'user_photo_upload_' . $request->id; // Define the key for rate limiting
        if (RateLimiter::tooManyAttempts($key, 4)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($key, 200); // 10 minutes in seconds

        // If no user is provided, use the authenticated user
        if (!$user) {
            $user = $request->user();
        } else {
            // Check if the authenticated user is an admin
            if ($request->user()->type !== 'admin') {
                return response()->json(['message' => 'Forbidden'], 403);
            }
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
    
            // Update the user's photo attribute with the correct path of the uploaded photo
            $user->photo = '/api/user/photo/' . $filename;
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
    
    public function servePhoto($filename)
    {
        $path = storage_path('app/public/users/' . $filename); // Corrected the path to match where the photos are stored

        if (!file_exists($path)) {
            abort(404); // Return a 404 error if the file does not exist
        }

        return response()->file($path); // Serve the file
    }
}
