<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Doctor extends Model
{
    use HasFactory;

    public static function generateSlug($name)
    {
        return  Str::slug($name, '-');
    }

    protected $fillable = ['user_id', 'curriculum_vitae' , 'photo' , 'phone' , 'description' , 'address' , 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
