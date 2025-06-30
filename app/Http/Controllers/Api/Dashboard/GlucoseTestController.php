<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Patient\GlucoseTestResource;
use App\Models\GlucoseTest;
use Illuminate\Http\Request;

class GlucoseTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $glucoseTests = GlucoseTest::latest('id')->with('patient:id,name')->paginate(request('per_page', 15));

            return GlucoseTestResource::collection($glucoseTests)
                    ->additional([
                        'message' => 'Glucose tests retrieved successfully'
                    ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $glucoseTest = GlucoseTest::create($request->all());

            return GlucoseTestResource::make($glucoseTest->load(['patient']));
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
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
    public function destroy($id)
    {
        $glucoseTest = GlucoseTest::findOrFail($id);
        $glucoseTest->delete();
        return response()->json(['message' => 'Glucose test deleted successfully']);
    }
}
