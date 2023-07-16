<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;
use App\Models\User;

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
        return view('dashboard', compact('doctor', 'user'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::all();
        return view('admin.doctor.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'curriculum_vitae' => 'nullable',
                'description' => 'required|max:255',
                'photo' => 'nullable|image',
                'phone' => 'required|max:20',
                'specializations' => 'exists:specializations,id'
            ]
        );

        $form_data = $request->all();

        // if($request->hasFile('img')){
        //     $path = Storage::disk('public')->put('project_images', $request->img);
        //     $form_data['img'] = $path;
        // }


        // $slug = Project::generateSlug($request->name);

        // $form_data['slug'] = $slug;



      
        $new_doctor = new Doctor();
        $form_data['user_id'] = Auth::user()->id;
        $new_doctor->fill($form_data);
        

        $new_doctor->save();

        if($request->has('specializations')){
            $new_doctor->specializations()->attach($request->specializations);
        };
        //return redirect()->route('admin.dashboard.index');
        return redirect()->route('admin.dashboard.show',$new_doctor);
       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    $doctor = Doctor::where('user_id', Auth::user()->id)->first();
        $user = Auth::user();

        $showDoctor =  Doctor::findOrFail($id);
        return view('admin.doctor.show', compact('showDoctor','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $specializations = Specialization::all();
        $mod_doctor =  Doctor::findOrFail($id);
        return view('admin.doctor.edit', compact('specializations','mod_doctor'));
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
        //
        $request->validate(
            [
                'curriculum_vitae' => 'nullable',
                'description' => 'required|max:255',
                'photo' => 'nullable|image',
                'phone' => 'required|max:20',
                'specializations' => 'exists:specializations,id'
            ]
        );
        $form_data = $request->all();
        $specializations = Specialization::all();
        $mod_doctor =  Doctor::findOrFail($id);
        $mod_doctor->update($form_data);

        if( $request->has('specializations') ){
           
            $mod_doctor->specializations()->sync($request->specializations);
           }
              
        else{
           
            $mod_doctor ->specializations()->sync([]);
           }
           return redirect()->route('admin.dashboard.show',$mod_doctor);
           //return ( 'admin.doctor.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $mod_doctor =  Doctor::findOrFail($id);
        $mod_doctor->specializations()->sync([]);

        // if( $mod_post->image) {
        //     Storage::delete($mod_post->image);
        //      }
        $mod_doctor->delete();
        return redirect()->route('admin.dashboard.index');
    }
}