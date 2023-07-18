<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;
use App\Models\User;
use App\Models\Admin\Message;
use App\Models\Admin\Review;
use Illuminate\Support\Facades\Storage;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctor = Doctor::where('user_id', Auth::user()->id)->first();
        $user = Auth::user();
        if ($user->id !== auth()->user()->id) {
            abort(403, "Non hai il permesso di visualizzare questo profilo.");
        } else {
            if ($doctor){
                return view('admin.doctor.show', compact('doctor', 'user'));
            }else{
                return view('dashboard', compact('doctor', 'user'));
            }
        }
    }
        
        
        
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $specializations = Specialization::all();
        if ($user->id !== auth()->user()->id) {
            abort(403, "Non hai il permesso di visualizzare questo profilo.");
        } else {
            return view('admin.doctor.create', compact('specializations', 'user'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Doctor $doctor)
    {
        $request->validate(
            [
                'curriculum_vitae' => 'nullable|mimes:pdf,jpeg,jpg',
                'description' => 'required|max:255',
                'photo' => 'nullable|image',
                'phone' => 'required|numeric',
                'specializations' => 'required|exists:specializations,id',
            ],
            [
                'specializations.required' => 'At least one specializations is required.'
            ]
        );

        $form_data = $request->all();

        if($request->hasFile('photo')){
            $path_img = Storage::disk('public')->put('photo', $request->photo);
            $form_data['photo'] = $path_img;
        }
        if($request->hasFile('curriculum_vitae')){
            $path_cv = Storage::disk('public')->put('curriculum_vitae', $request->curriculum_vitae);
            $form_data['curriculum_vitae'] = $path_cv;
        }

        $new_doctor = new Doctor();
        
        $form_data['user_id'] = Auth::user()->id;
        $new_doctor->id = $form_data['user_id'];
        $new_doctor->fill($form_data);
        
        $new_doctor->save();

        if($request->has('specializations')){
            $new_doctor->specializations()->attach($request->specializations);
        };
        if ($new_doctor->id !== auth()->user()->id) {
            abort(403, "Non hai il permesso di visualizzare questo profilo.");
        } else {
            return redirect()->route('admin.dashboard.show', $new_doctor);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, User $user , Message $message , Review $review, Doctor $doctor)
    {
        
        $user = Auth::user();
        $doctor = Doctor::findOrFail($id);
        $messages = Message::all();
        $reviews = Review::all();
        if ($doctor->id !== auth()->user()->id) {
            abort(403, "Non hai il permesso di visualizzare questo profilo.");
        } else {
            return view('admin.doctor.show', compact( 'doctor' , 'user' , 'messages' , 'reviews'));    
        }
        }
        

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $specializations = Specialization::all();
        $doctor =  Doctor::findOrFail($id);
        if ($doctor->id !== auth()->user()->id) {
            abort(403, "Non hai il permesso di visualizzare questo profilo.");
        } else {
            return view('admin.doctor.edit', compact('specializations','doctor', 'user'));    
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'curriculum_vitae' => 'nullable|mimes:pdf,jpeg,jpg',
                'description' => 'required|max:255',
                'photo' => 'nullable|image',
                'phone' => 'required|numeric',
                'specializations' => 'required|exists:specializations,id',
                
            ],
            [
                'specializations.required' => 'At least one specializations is required.'
            ]
        );

        $doctor =  Doctor::findOrFail($id);
        $form_data = $request->all();
        if($request->hasFile('photo')){
            if( $doctor->photo ){
                Storage::delete($doctor->photo);
            }
            $path = Storage::disk('public')->put('photo', $request->photo);
            $form_data['photo'] = $path;
        }
        if ($request->has('delete_photo')) {
            if ($doctor->photo) {
                Storage::delete($doctor->photo);
                $doctor->photo = null;
            }
        }
        if($request->hasFile('curriculum_vitae')){
            if( $doctor->curriculum_vitae ){
                Storage::delete($doctor->curriculum_vitae);
            }
            $path_cv = Storage::disk('public')->put('curriculum_vitae', $request->curriculum_vitae);
            $form_data['curriculum_vitae'] = $path_cv;
        }
        if ($request->has('delete_cv')) {
            if ($doctor->curriculum_vitae) {
                Storage::delete($doctor->curriculum_vitae);
                $doctor->curriculum_vitae = null;
            }
        }
        $form_data['user_id'] = Auth::user()->id;
        $doctor->id = $form_data['user_id'];
        $doctor->update($form_data);
        

        if($request->has('specializations')){
            $doctor->specializations()->sync($request->specializations);
        }elseif(!$request->has('specializations')){
            $doctor->specializations()->sync([]);                
        }
        if ($doctor->id !== auth()->user()->id) {
            abort(403, "Non hai il permesso di visualizzare questo profilo.");
        } else {
             return redirect()->route('admin.dashboard.show', $doctor);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor =  Doctor::findOrFail($id);
        $user = Auth::user();
        $doctor->delete();
        $doctor->specializations()->sync([]);
        return view('dashboard', compact('doctor', 'user'));
    
    }
}