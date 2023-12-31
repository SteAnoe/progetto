<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Message;
use App\Models\User;
use App\Models\Admin\Doctor;

class MessageController extends Controller
{
    public function store(Request $request){
        $request->validate(
            [
                'doctor_id' => 'required|integer', 
                'email' => 'required|string',
                'name' => 'required|string',
                'lastname' => 'nullable|string',
                'text' => 'required|string',

            ],
            [

            ]
        );
        $form_data = $request->all();
        $doctor = Doctor::findOrFail($request->doctor_id);
        $message = new Message();
        $message->fill($form_data);
        $message->doctor_id = $doctor->id;
        $doctor->messages()->save($message);
        return response()->json([
            'message' => 'Message sent successfully',
            'success' => true
        ], 200);
    }
}
