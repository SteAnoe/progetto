<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Sponsorship extends Model
{
    use HasFactory;

    public static function generateSlug($level)
    {
        return  Str::slug($level, '-');
    }

    protected $fillable = ['level' , 'description' , 'price' , 'duration' , 'slug'];

    public function doctors(){
        return $this->belongsToMany(Doctor::class, 'doctor_sponsorship', 'sponsorship_id', 'doctor_id')->withPivot('expire');
    }
}
