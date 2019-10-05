<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    protected $fillable = ['donate_id', 'image'];

    public function donate()
    {
    	return $this->belongsTo(Donation::class);
    }
}
