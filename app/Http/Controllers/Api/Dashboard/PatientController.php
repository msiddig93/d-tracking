<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\PatientResource;
use App\Http\Requests\Dashboard\PatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        sleep(1);
        $patients = Patient::latest('id')->paginate($request->get('per_page', 10));
        return PatientResource::collection($patients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if($id == 'list') {
            $patients = Patient::get(['id', 'name']);
            return response()->json($patients);
        }

        $patient = Patient::findOrFail($id);
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());
        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
