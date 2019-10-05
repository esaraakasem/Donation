<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeminarResource extends JsonResource
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
            'image' => getImgPath($this->image),
            'date' => $this->date->format('Y / m / d'),
            'address' => $this->address,
            'lat' => $this->lat ?? 0,
            'lng' => $this->lng ?? 0,
            'notes' => null_string($this->notes)
        ];
    }
}
