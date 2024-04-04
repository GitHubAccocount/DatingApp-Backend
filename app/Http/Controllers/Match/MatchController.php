<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        // Get the ID of the authenticated user
        $userId = auth()->id();

        // Retrieve personal information of the authenticated user
        $user = PersonalInformation::where('user_id', $userId)->first();

        // Find users matching the desired empathy level and gender
        $matchedUsers = User::whereHas('personalInformation', function (Builder $query) use ($user) {
            $query->where('own_emapthy_level', '=', $user->desired_emapthy_level)
                ->where('gender', '=', $user->look_for)
                ->where('look_for', '=', $user->gender)
                ->where('desired_emapthy_level', '=', $user->own_emapthy_level);
        })
            ->with('personalInformation')->get();

        // Return a JSON response containing matched users
        return response()->json($matchedUsers);
    }
}
