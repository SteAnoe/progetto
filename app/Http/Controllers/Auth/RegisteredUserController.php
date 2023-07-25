<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $specializations = Specialization::all();
        return view('auth.register', compact('specializations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specializations' => 'required|exists:specializations,id',
            'address' => 'required'
        ],
        [
            'specializations.required' => 'At least one specializations is required.'
        ]);

        $lastname = $request->lastname;
        $name = $request->name;
        $slug = User::generateSlug($lastname, $name);
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'slug' => $slug,
            'address' => $request->address,
        
        ]);

        event(new Registered($user));
        Auth::login($user);

        $doctor = Doctor::create([
            'user_id' => Auth::user()->id,
        ]);

        // $form_data = $request->all();
        // $new_doctor = new Doctor();
        
        // $form_data['user_id'] = Auth::user()->id;
        // $new_doctor->id = $form_data['user_id'];
        // $new_doctor->fill($form_data);
        // $new_doctor->save();
        
        if($request->has('specializations')){
            $doctor->specializations()->attach($request->specializations);
        };

        

        

        return redirect(RouteServiceProvider::HOME);
        
    }
}
