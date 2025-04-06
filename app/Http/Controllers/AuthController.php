<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request){
        // Get the user's IP address
        $ipAddress = $request->ip();

        // Check if the IP address has exceeded the allowed number of registration attempts
        if (RateLimiter::tooManyAttempts($ipAddress, 3)) { // Allow 3 attempts per minute
            Log::info('Too many registration attempts.', ['data' => $request]);
            return response()->json(['message' => 'Too many registration attempts from this IP. Please try again later.'], 429);
        }
        // Increment the registration attempt counter
        RateLimiter::hit($ipAddress,600);

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8|confirmed|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'want_news' => 'nullable|boolean',
            ], [
            'name.required' => 'Name is required and must be a string with a maximum length of 255 characters.',
            'name.max' => 'Name must not exceed 255 characters.',
            'last_name.max' => 'Last name must not exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'The provided email is invalid.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number must not exceed 15 characters.',
            'phone.unique' => 'This phone number is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'want_news.boolean' => 'Want news must be a boolean value if provided.',
        ]);
        $user = User::create($fields);

        $token = $user->createToken($user->email)->plainTextToken;
        Log::info('User logged in successfully.', ['user_id' => $user->id]);

        return response()->json(['user' => $user, 'token' => $token], 201);

    }
    public function editUser(Request $request) {

        // Validation with custom error messages
        $fields = $request->validate([
            'name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $request->user()->id,
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $request->user()->id,
            'password' => 'nullable|string|min:8|confirmed|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'want_news' => 'nullable|boolean',
        ], [
            'name.max' => 'Name must not exceed 255 characters.',
            'last_name.max' => 'Last name must not exceed 255 characters.',
            'email.email' => 'The provided email is invalid.',
            'email.unique' => 'This email is already registered.',
            'phone.max' => 'Phone number must not exceed 15 characters.',
            'phone.unique' => 'This phone number is already registered.',
            'password.min' => 'Password must be at least 8 characters long if provided.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'want_news.boolean' => 'Want news must be a boolean value if provided.',
        ]);
    
        // Retrieve the authenticated user
        $user = $request->user();
    
        // Update fields if provided
        if (isset($fields['name'])) {
            $user->name = $fields['name'];
        }
        if (isset($fields['email'])) {
            $user->email = $fields['email'];
        }
        if (isset($fields['last_name'])) {
            $user->last_name = $fields['last_name'];
        }
        if (isset($fields['phone'])) {
            $user->phone = $fields['phone'];
        }
        if (isset($fields['password'])) {
            $user->password = bcrypt($fields['password']);
        }
        if (isset($fields['want_news'])) {
            $user->want_news = $fields['want_news'];
        }
        // log changes
        Log::info('User updated successfully.', ['user_id' => $user->id, 'changes' => $fields]);

        
        // Save the updated user record
        $user->save();
    
        // Return response
        return response()->json(['user' => $user], 200);
    }
    public function login(Request $request){
        $identifier = $request->input('identifier');
        if (RateLimiter::tooManyAttempts($identifier, 5)) {
            Log::info('Too many login attempts.', ['data' => $request]);
            return response()->json(['message' => 'Too many login attempts. Please try again later.'], 429);
        }
        // Increment the login attempt counter
        RateLimiter::hit($identifier,600);
        
        // Get the user's IP address
        $ipAddress = $request->ip();

        // Check if the IP address has exceeded the allowed number of registration attempts
        if (RateLimiter::tooManyAttempts($ipAddress, 5)) { // Allow 3 attempts per minute
            Log::info('Too many login attempts IP address: ' . $ipAddress, ['data' => $request]);
            return response()->json(['message' => 'Too many registration attempts from this IP. Please try again later.'], 429);
        }
        // Increment the registration attempt counter
        RateLimiter::hit($ipAddress,600);


        $ipAddress = $request->ip();
        Log::info('User logged in from IP address: ' . $ipAddress);
        
        $fields = $request->validate([
            'identifier' => 'required|string', // This will accept either email or phone
            'password' => 'required|string|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            ], [
            'identifier.required' => 'The identifier field is required.',
            'identifier.string' => 'The identifier must be a string.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, special charecter numbers',
        ]);

        
        $user = User::where('email', $fields['identifier'])
                    ->orWhere('phone', $fields['identifier'])
                    ->first();

        if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $fields['password']])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken($user->email)->plainTextToken;
        // $user->token = $token; // Add token to user model (if you want to store it)
        return response()->json(['user' => $user, 'token' => $token], 200);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();        
        return response()->json(['message' => 'You are logged out from all devices.'], 200);
    }
}
