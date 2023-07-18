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
        $users = User::all();
        $specializations = Specialization::all();
        return response()->json(
            [
                'success' => true,
                'doctors' => $doctors
            ]
        );
    }
}