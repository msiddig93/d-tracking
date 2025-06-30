<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Dashboard\MedicationResource;
use App\Http\Requests\Dashboard\MedicationRequest;
use App\Models\Medication;
use Symfony\Component\HttpFoundation\Response;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medications = Medication::latest('id')->with([
            'patient:id,name'
        ])->paginate(request('per_page', 15));
        
        return MedicationResource::collection($medications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicationRequest $request)
    {
        try{
            $medication = Medication::updateOrCreate([
                'id' => $request->id
            ],$request->validated());
        return new MedicationResource($medication);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medication = Medication::findOrFail($id);
        return new MedicationResource($medication);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicationRequest $request, $id)
    {
        $medication = Medication::findOrFail($id);
        $medication->update($request->validated());
        return new MedicationResource($medication);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();
        return response()->json(['message' => 'Medication deleted successfully']);
    }
}
