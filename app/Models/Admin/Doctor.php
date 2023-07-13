<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'curriculum_vitae' , 'photo' , 'phone' , 'description' , 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function specializations(){
	    return $this->belongsToMany(Specialization::class);
    }

    public function sponsorships(){
	    return $this->belongsToMany(Sponsorship::class);
    }
}
