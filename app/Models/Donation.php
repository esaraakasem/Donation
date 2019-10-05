<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    
    protected $fillable = ['type', 'status', 'category', 'requested_price', 'sent_price', 'title', 'details', 'address', 'is_done', 'age', 'size', 'school_year', 'user_id', 'lat', 'lng'];

    public function images()
    {
    	return $this->hasMany(Image::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
    	return $this->belongsTo(User::class, 'admin_id');
    }
}
