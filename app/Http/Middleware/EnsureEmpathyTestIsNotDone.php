<?php

namespace App\Http\Middleware;

use App\Models\Answer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmpathyTestIsNotDone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->id();
        $answer = Answer::where('user_id', $userId)->exists();

        if ($answer) {
            return response()->json([
                'message' => 'You have already submitted the form.'
            ], 409);
        }

        return $next($request);
    }
}
