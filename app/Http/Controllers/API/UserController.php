<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use Illuminate\Http\Response;
use App\Models\Donation;
use App\Http\Resources\DonationResource;
use App\Http\Resources\NotificationCollection;

class UserController extends Controller
{
    use ApiResponses;

    public function donate($type)
    {
    	if ($type == 'money') {
    		$rules = [
	    		'title' => 'required',
	    		'address' => 'required',
                'lat' => 'required',
                'lng' => 'required',
	    		'category' => 'required',
	    		'requested_price' => 'required'
	    	];
    	} elseif ($type == 'cloth') {
    		$rules = [
	    		'title' => 'required',
	    		'address' => 'required',
                'lat' => 'required',
                'lng' => 'required',
	    		'category' => 'required',
	    		'age' => 'required',
	    		'size' => 'required'
	    	];
    	} elseif ($type == 'food') {
    		$rules = [
	    		'title' => 'required',
	    		'address' => 'required',
                'lat' => 'required',
                'lng' => 'required',
	    		'category' => 'required',
	    		'details' => 'required'
	    	];
    	} else {
    		$rules = [
	    		'title' => 'required',
	    		'address' => 'required',
                'lat' => 'required',
                'lng' => 'required',
	    		'category' => 'required',
	    		'school_year' => 'required'
	    	];
    	}

    	$validation = $this->apiValidation(request(), $rules);
    	if ($validation instanceof Response) { return $validation; }

    	$donate = auth()->user()->donates()->create(request()->except('images'));

    	if (request()->hasFile('images')) {
    		foreach (request('images') as $img) {
    			$donate->images()->create([
    				'image' => uploadImage($img)
    			]);
    		}
    	}

    	return $this->apiResponse(new DonationResource($donate));
    }
    
    public function notifications()
    {
    	$user = auth()->user();
        $notifications = $user->notifications()->orderByDesc('created_at')->paginate($this->paginateNumber);
        $user->unReadNotifications->markAsRead();
        return $this->apiResponse(new NotificationCollection($notifications));
    }

    public function noNotifications()
    {
        $user = auth()->user();
        $count = $user->unReadNotifications->count();
        return $this->apiResponse($count);
    }
}
