<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\Doctor;
use App\Models\Admin\Review;
class ReviewController extends Controller
{
    public function store(Request $request){
        $request->validate(
            [
                'doctor_id' => 'required|integer', 
                'stars' => 'required|numeric',
                'name' => 'required|string',              
                'text' => 'required|string',

            ],
            [

            ]
        );
        $form_data = $request->all();
        $doctor = Doctor::findOrFail($request->doctor_id);
        $review = new Review();
        $review->fill($form_data);
        $review->doctor_id = $doctor->id;
        $doctor->reviews()->save($review);
        return response()->json([
            'review' => 'review sent successfully',
            'success' => true
        ], 200);
    }
}
