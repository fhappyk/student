<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    final public function children(Request $request, Speciality $speciality)
    {
        try {
            $children = $speciality->children()->get();
            return response()->json([
                'status' => 'success',
                'data' => $children
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
