<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Specialization extends Model
{
    use HasFactory;

    public static function generateSlug($name)
    {
        return  Str::slug($name, '-');
    }

    protected $fillable = ['name' , 'slug', 'img'];

    public function doctors(){
        return $this->belongsToMany(Doctor::class);
    }

}