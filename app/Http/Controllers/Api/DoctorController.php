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
    public function index(){
        $doctors = Doctor::all();
        $users = User::all()->toArray();
        $specializations = Specialization::all()->toArray();

        return response()->json(
            [
                'success' => true,
                'doctors' => $doctors,
                // ['doctors' => $doctors,'users' => $users,'specializations'=> $specializations]
                
                
            ]
        );

        // $queryDoctors = Doctor::with(['reviews','technologies']);
        // if ($request->has('type_id')){
        //     $query->where('type_id', $request->type_id);
        // }
        // if($request->has('technologies_ids')){
        //     $technologyIds = explode(',', $request->technologies_ids);
        //     $query->whereHas('technologies', function($query) use ($technologyIds){
        //         $query->whereIn('id', $technologyIds);
        //     });
        // }

        // $projects = $query->paginate(3);
        //     return response()->json([
        //     'success' => true,
        //     'projects' => $projects
        // ]);
        //}
    }
}