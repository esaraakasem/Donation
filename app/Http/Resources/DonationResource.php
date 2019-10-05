<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'address' => $this->address,
            'lat' => $this->lat ?? 0,
            'lng' => $this->lng ?? 0,
            'requested_price' => null_string($this->requested_price),
            'school_year' => null_string($this->school_year),
            'details' => null_string($this->details),
            'age' => null_string($this->age),
            'size' => null_string($this->size),
            'images' => ImagesResource::collection($this->images)
        ];
    }
}
