<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Message extends Model
{
    use HasFactory;

    public static function generateSlug($name)
    {
        return  Str::slug($name, '-');
    }

    protected $fillable = ['doctor_id', 'email' , 'name' , 'lastname' , 'text', 'slug'];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
