<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Specialization;
use App\Models\Admin\Doctor;
use App\Models\Admin\Sponsorship;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
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

    public function show(Request $request, $slug)
{
    $query = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
    ->select('doctors.*', 'users.name', 'users.slug', 'users.lastname', 'users.email', 'users.address')
    ->with('specializations', 'reviews', 'sponsorships')
    ->withCount('reviews')
    ->whereHas('specializations', function ($query) use ($slug) {
        $query->where('slug', $slug);
    });

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

    $query->orderByRaw("CASE WHEN EXISTS (SELECT * FROM doctor_sponsorship WHERE doctors.id = doctor_sponsorship.doctor_id AND expire > NOW()) THEN 0 ELSE 1 END");

    $doctors = $query->get();

    return response()->json([
        'doctors' => $doctors,
    ]);

}

}