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
        $validated = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'empathyLevel' => ['required', 'in:low,average,high,very high'],
            'lookingFor' => ['required', 'in:male,female'],
            'description' => ['nullable']
        ]);

        $userId = auth()->id();

        $ownEmpathyLevel = $this->calculateEmpathyLevelService->getEmpathyLevel($validated['gender']);

        $personalInformationData = [
            'user_id' => $userId,
            'own_emapthy_level' => $ownEmpathyLevel,
            'gender' => $validated['gender'],
            'look_for' => $validated['lookingFor'],
            'desired_emapthy_level' => $validated['empathyLevel'],
            'description' => $validated['description'],
        ];

        PersonalInformation::create($personalInformationData);


        return response()->noContent();
    }

    public function getFormSubmissionState()
    {
        $userId = auth()->id();
        $personalInfo = PersonalInformation::where('user_id', $userId)->exists();

        return response()->json([
            'submitted' => $personalInfo
        ]);
    }
}
