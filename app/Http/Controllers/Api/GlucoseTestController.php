<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GlucoseTestRequest;
use App\Http\Resources\Api\Patient\GlucoseTestResource;
use App\Models\GlucoseTest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GlucoseTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $glucoseTests = GlucoseTest::where('patient_id', request()->user()->id)
                ->latest('id')
                ->get();
                // ->paginate(request()->get('per_page', 10));

            return GlucoseTestResource::collection($glucoseTests)->additional([
                'message' => 'Glucose tests retrieved successfully',
                'last_test' => GlucoseTest::where('patient_id', request()->user()->id)
                    ->latest('id')
                    ->first() 
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving glucose tests',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GlucoseTestRequest $request)
    {
        try {
            $data = $request->validated();
            $data['patient_id'] = $request->user()->id; // Assuming the user is a patient

            // Create the glucose test record
            $glucoseTest = GlucoseTest::create($data);

            if($glucoseTest->level > 200) {
                // Send alert to all doctors if glucose level is high
                $doctors = User::get(['name', 'email']);
                foreach ($doctors as $doctor) {
                    Log::info("Sending high glucose alert to doctor: {$doctor->email}");
                    Mail::to($doctor->email)->send(new \App\Mail\GlucoseTestAlertDoctor(
                        $request->user(),
                        $glucoseTest,
                        'high'
                    ));
                }
            } elseif ($glucoseTest->level < 70) {
                // Send alert to all doctors if glucose level is low
                $doctors = User::get(['name', 'email']);
                foreach ($doctors as $doctor) {
                    Mail::to($doctor->email)->send(new \App\Mail\GlucoseTestAlertDoctor(
                        $request->user(),
                        $glucoseTest,
                        'low'
                    ));
                }
            }

            return response()->json([
                'message' => 'Glucose test created successfully',
                'data' => $glucoseTest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating glucose test',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
