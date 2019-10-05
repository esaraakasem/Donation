<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use Illuminate\Http\Response;
use App\Models\Donation;
use App\Models\Seminar;
use App\Notifications\DonationRequest;
use App\Http\Resources\DonationResource;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\SeminarResource;
use App\Http\Resources\SeminarCollection;
use App\Http\Resources\DonationCollection;

class AdminController extends Controller
{
    use ApiResponses;

    public function addSeminar()
    {
    	$rules = [
    		'image' => 'required|image',
    		'date' => 'required',
            'title' => 'required',
    		'address' => 'required',
            'lat' => 'required',
            'lng' => 'required'
    	];

    	$validation = $this->apiValidation(request(), $rules);
    	if ($validation instanceof Response) { return $validation; }

    	$data = request()->all();
    	if (request()->hasFile('image')) {
    		$data['image'] = uploadImage(request('image'));
    	}
    	$seminar = auth()->user()->seminars()->create($data);

    	return $this->apiResponse(new SeminarResource($seminar));
    }

    public function getSeminar()
    {
    	$seminar = Seminar::latest()->paginate($this->paginateNumber);
    	return $this->apiResponse(new SeminarCollection($seminar));
    }

    public function donationRequests($type)
    {
    	$data = [
    		'cloth' => 'مﻻبس',
    		'money' => 'مال',
    		'school' => 'أدوات مدرسية',
    		'food' => 'مواد غذائية'
    	];

    	$requests = Donation::where('category', $data[$type])->where('status', null)->latest()->paginate($this->paginateNumber);
    	return $this->apiResponse(new DonationCollection($requests));
    }

    public function donation(Donation $donate)
    {
    	return $this->apiResponse(new DonationResource($donate));
    }

    public function changeDonation(Donation $donate)
    {
    	$donate->update(['status' => request('status'), 'admin_id' => auth()->id()]);
    	/**
		Notification
    	**/
        $donate->user->notify(new DonationRequest($donate));
    	return $this->apiResponse(new DonationResource($donate));
    }

    public function donateMoney(Donation $donate)
    {
    	$rules = [
    		'sent_price' => 'required',
    		'type' => 'required'
    	];

    	$validation = $this->apiValidation(request(), $rules);
    	if ($validation instanceof Response) { return $validation; }

    	$donate->update(['type' => request('type'), 'sent_price' => request('sent_price'), 'status' => 'accept', 'admin_id' => auth()->id()]);
    	/**
		Notification
    	**/
        $donate->user->notify(new DonationRequest($donate));
    	return $this->apiResponse(new DonationResource($donate));
    }
}
