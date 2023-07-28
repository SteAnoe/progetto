<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Doctor;
class SponsorshipController extends Controller
{
    public function onlyDocsWithSponsorships()
    {
        $doctors = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
            ->select('doctors.*', 'users.name', 'users.slug', 'users.lastname', 'users.email', 'users.address')
            ->with(['specializations', 'sponsorships' => function ($query) {
                $query->where('expire', '>', now()); // Assuming 'expire' is the column indicating sponsorship validity
            }])
            ->whereHas('sponsorships', function ($query) {
                $query->where('expire', '>', now()); // Assuming 'expire' is the column indicating sponsorship validity
            })
            ->get();

        return response()->json([
            'doctors' => $doctors,
        ]);
    }
}
