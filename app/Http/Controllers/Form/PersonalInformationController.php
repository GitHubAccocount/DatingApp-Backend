<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use App\Services\CalculateEmpathyLevelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalInformationController extends Controller
{
    public function __construct(
        protected CalculateEmpathyLevelService $calculateEmpathyLevelService
    ) {
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'empathyLevel' => ['required', 'in:low,average,high,very high'],
            'lookingFor' => ['required', 'in:male,female'],
            'description' => ['nullable']
        ]);

        // Get the ID of the authenticated user
        $userId = auth()->id();

        // Calculate own empathy level based on gender
        $ownEmpathyLevel = $this->calculateEmpathyLevelService->getEmpathyLevel($validated['gender']);

        // Prepare personal information data
        $personalInformationData = [
            'user_id' => $userId,
            'own_emapthy_level' => $ownEmpathyLevel,
            'gender' => $validated['gender'],
            'look_for' => $validated['lookingFor'],
            'desired_emapthy_level' => $validated['empathyLevel'],
            'description' => $validated['description'],
        ];

        // Create personal information record in the database
        PersonalInformation::create($personalInformationData);

        // Return a successful response
        return response()->noContent();
    }

    public function getFormSubmissionState()
    {
        // Get the ID of the authenticated user
        $userId = auth()->id();
        // Check if personal information exists for the user
        $personalInfo = PersonalInformation::where('user_id', $userId)->exists();

        // Return a JSON response indicating whether the form has been submitted
        return response()->json([
            'submitted' => $personalInfo
        ]);
    }
}
