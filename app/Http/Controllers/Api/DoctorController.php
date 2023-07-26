<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;
use App\Models\User;
use App\Models\Admin\Review;


class DoctorController extends Controller
{
    //
    public function index(Request $request){
        
        
         $query = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
                ->select('doctors.*', 'users.name', 'users.slug', 'users.lastname', 'users.email', 'users.address')
                ->with('specializations','reviews')
                ->withCount('reviews');
                
        
        
        $query->selectSub(function ($query) {
            $query->selectRaw('coalesce(avg(stars), 0)')
                ->from('reviews')
                ->whereColumn('reviews.doctor_id', 'doctors.id');
        }, 'avg_stars');
    
        if ($request->has('minVoteFilter')) {
            $minVoteFilter = (int) $request->minVoteFilter;
    
            $query->having('avg_stars', '>=', $minVoteFilter);
        }
        if ($request->has('sortBy')) {
            $sortBy = $request->sortBy;
            if ($sortBy === 'reviews') {
                $query->orderByDesc('reviews_count');
            } elseif ($sortBy === 'average_vote') {
                $query->orderByDesc('avg_stars');
            }
        }
        //$doctors = $query->paginate(3);
        $doctors = $query->get();
        return response()->json([
            'success' => true,
            'doctors' => $doctors,
        ]); 
    }
    public function show($slug){
        $doctor = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
        ->select('doctors.*', 'users.name', 'users.slug as user_slug', 'users.lastname', 'users.email', 'users.address')
        ->with('specializations', 'reviews')
        ->where('users.slug', $slug)
        ->first();
        if($doctor){
            return response()->json([
                'success' => true,
                'doctor' => $doctor
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Non ci sono doctors'
            ]);
        }
    }
    
}