<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class GlucoseTestController extends Controller
{
    public function __invoke(Request $request){
        try{
            return Inertia::render('GlucoseTest/Index', [

            ]);
        }catch(\Exception $e){
            Log::error([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return redirect()->back();
        }
    }
}
