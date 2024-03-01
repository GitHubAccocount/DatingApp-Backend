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
        $userId = auth()->id();

        $user = PersonalInformation::where('user_id', $userId)->first();

        // $matchedUsers = DB::table('personal_information')->where([
        //     ['own_emapthy_level', '=', $user->desired_emapthy_level],
        //     ['gender', '=', $user->look_for],
        //     ['look_for', '=', $user->gender],
        //     ['desired_emapthy_level', '=', $user->own_emapthy_level]
        // ])->get();

        $matchedUsers = User::whereHas('personalInformation', function (Builder $query) use ($user) {
            $query->where('own_emapthy_level', '=', $user->desired_emapthy_level)
                ->where('gender', '=', $user->look_for)
                ->where('look_for', '=', $user->gender)
                ->where('desired_emapthy_level', '=', $user->own_emapthy_level);
        })
            ->with('personalInformation')->get();


        return response()->json($matchedUsers);
    }
}
