<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Specialization;

class SpecializationController extends Controller
{   
    public function index() {
    $specializations = Specialization::all();

        return response()->json(
        [
            'success' => true,
            'specializations' => $specializations,
        ]
        );
    }
}