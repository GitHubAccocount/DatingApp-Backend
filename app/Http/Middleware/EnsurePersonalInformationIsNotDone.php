<?php

namespace App\Http\Middleware;

use App\Models\PersonalInformation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePersonalInformationIsNotDone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->id();
        $personalInfo = PersonalInformation::where('user_id', $userId)->exists();

        if ($personalInfo) {
            return response()->json([
                'message' => 'You have already submitted the form.'
            ], 409);
        }

        return $next($request);
    }
}
