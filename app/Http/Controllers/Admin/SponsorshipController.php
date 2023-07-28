<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Doctor;
use Braintree\Gateway;
use App\Models\User;
use App\Models\Admin\Message;
use App\Models\Admin\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Sponsorship;
use Carbon\Carbon;
class SponsorshipController extends Controller
{
    
    public function token(Request $request, Doctor $doctor, User $user, Message $message , Review $review){
    
    $user = Auth::user();
    $doctor = Doctor::where('user_id', Auth::user()->id)->first();
    
    $messages = Message::all();
    $reviews = Review::all();
    
    $gateway = new Gateway([
        'environment' => env('BRAINTREE_ENVIRONMENT'),
        'merchantId' => env('BRAINTREE_MERCHANT_ID'),
        'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
        'privateKey' => env('BRAINTREE_PRIVATE_KEY')
    ]);
    
    $form_data = $request->all();
    


    // Proceed with payment processing if validation passes
    $nonceFromTheClient = $request->input('nonce');
    $selectedSponsorship = $request->input('amount');// Assuming 1, 2, or 3 for 24, 72, or 144 hours respectively
    $result = $gateway->transaction()->sale([
        'amount' => $selectedSponsorship, // Use the correct amount format
        'paymentMethodNonce' => $nonceFromTheClient,
        'options' => [
            'submitForSettlement' => true,
        ],
    ]);

    $hours = 0;
    switch ($selectedSponsorship) {
        case 1:
            $hours = 24;
            break;
        case 2:
            $hours = 72;
            break;
        case 3:
            $hours = 144;
            break;
        default:
            // Handle invalid selected sponsorship level
            return redirect()->route('payment.error');
    }

    $existingSponsorship = $doctor->sponsorships->where('pivot.sponsorship_id', $selectedSponsorship)->first();

    // dd('Selected sponsorship:', $selectedSponsorship);
    // dd('Existing sponsorship:', $existingSponsorship);
    if ($existingSponsorship) {
        // Calculate the new expiration time by adding hours to the existing time
        $expireTime = \Carbon\Carbon::parse($existingSponsorship->pivot->expire)->addHours($hours);
        
        // Update the expiration time of the existing sponsorship
        $doctor->sponsorships()->updateExistingPivot($selectedSponsorship, ['expire' => $expireTime]);
    } else {
        // Calculate the expiration time for the new sponsorship
        $expireTime = now()->addHours($hours);
        
        // Attach the new sponsorship with the expiration time
        $doctor->sponsorships()->attach($selectedSponsorship, ['expire' => $expireTime]);
    }

        $clientToken = $gateway->clientToken()->generate();
        return view('admin.doctor.sponsor', ['token' => $clientToken], compact('doctor', 'gateway', 'user', 'messages' , 'reviews'));
    }


    
    
}
