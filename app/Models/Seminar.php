<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    
    protected $fillable = ['user_id', 'title', 'image', 'date', 'address', 'notes', 'lat', 'lng'];

    protected $dates = ['date'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
}
