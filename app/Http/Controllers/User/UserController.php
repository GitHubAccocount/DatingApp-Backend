<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(Request $request)
    {
        // Get the ID of the authenticated user
        $userId = auth()->id();

        // Validate the incoming request data
        $validated = $request->validate([
            'profile_picture' => ['image', 'nullable', 'max:5000'],
            'name' => ['required', 'string', 'max:30'],
            'surname' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', "unique:users,email, $userId"],
        ]);

        // Find the user by ID
        $user = User::where('id', $userId)->first();

        // Get the base URL for storage
        $baseUrl = Storage::url('');
        // If a new profile picture is uploaded
        if ($request->hasFile('profile_picture')) {
            // Define the default profile picture URL
            $defaultProfilePictureUrl = $baseUrl . 'userPhotos/defaultProfilePicture.png';

            // If the current profile picture is not the default one, delete it
            if ($user->profile_picture !== $defaultProfilePictureUrl) {
                Storage::delete($user->profile_picture);
            }

            // Store the new profile picture in storage
            $path = $request->file('profile_picture')->store('userPhotos');
            // Set the profile picture URL in the validated data
            $validated['profile_picture'] = Storage::url($path);
        }

        // Update the user with the validated data
        $user->update($validated);

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Your profile has been updated succesfully.'
        ]);
    }
}
