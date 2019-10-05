<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeminarCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [ 'seminars' => $this->collection->transform(function ($q) {
            return [
                'id' => $q->id,
                'title' => $q->title,
                'image' => getImgPath($q->image),
                'date' => $q->date->format('Y / m / d'),
                'address' => $q->address,
                'lat' => $q->lat ?? 0,
                'lng' => $q->lng ?? 0,
                'notes' => null_string($q->notes)
            ];
        })
            ,
            'paginate' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'next_page_url'=>$this->nextPageUrl(),
                'prev_page_url'=>$this->previousPageUrl(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ]
        ];
    }
}
