<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function allList(){
        
        try {
            $data = User::where('role', 'student')->where('status', 'active')->get();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data',
            ], 500);
        }
    }
    
    public function viewStudent($id){


    try {
        $data = User::with('studentinfo')->find($id);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching data',
        ], 500);
    }


 
    }
}
