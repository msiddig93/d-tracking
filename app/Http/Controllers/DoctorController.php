<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\StoreDoctorRequest;
use App\Http\Resources\Api\Dashboard\DoctorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest('id')
            ->paginate(request('per_page', 15));

        return DoctorResource::collection($data)
                ->additional([
                    'message' => 'Doctors retrieved successfully',
                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        try{
            $data = $request->validated();
            if($request->id == 0){
                $data['password'] = bcrypt('password');
                $doctor = User::create($data);
            }else{
                $doctor = User::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }

            return DoctorResource::make($doctor)
                    ->additional([
                        'message' => 'Doctor created/updated successfully',
                    ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response()->noContent();
        }catch(\Exception $e){
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
