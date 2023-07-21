<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;
use App\Models\User;


class DoctorController extends Controller
{
    //
    public function index(Request $request){
        
        
        $query = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
                ->select('doctors.*', 'users.name', 'users.lastname', 'users.email', 'users.address')
                ->with('specializations','reviews');

        if ($request->has('specializations_ids')) {
            $specializationsIds = explode(',', $request->specializations_ids);
            $query->whereHas('specializations', function ($query) use ($specializationsIds) {
                $query->whereIn('id', $specializationsIds);
            });
        }

        $doctors = $query->get();

        return response()->json([
            'success' => true,
            'doctors' => $doctors,
        ]);
       
        // $projects = $query->paginate(3);
        //     return response()->json([
        //     'success' => true,
        //     'projects' => $projects
        // ]);
        //}
    }
}