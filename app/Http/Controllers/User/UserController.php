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
        $userId = auth()->id();

        $validated = $request->validate([
            'profile_picture' => ['image', 'nullable', 'max:5000'],
            'name' => ['required', 'string', 'max:30'],
            'surname' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', "unique:users,email, $userId"],
        ]);

        $user = User::where('id', $userId)->first();


        $baseUrl = Storage::url('');
        if ($request->hasFile('profile_picture')) {
            $defaultProfilePictureUrl = $baseUrl . 'userPhotos/defaultProfilePicture.png';
            if ($user->profile_picture !== $defaultProfilePictureUrl) {
                Storage::delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('userPhotos');
            $validated['profile_picture'] = Storage::url($path);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Your profile has been updated succesfully.'
        ]);
    }
}
