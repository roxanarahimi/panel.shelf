<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class SectorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => (string)$this->id,
            "title" => $this->title,
            "score" => $this->score,
            "active" => (boolean)$this->active,
            "province" => [
                'id'=> $this->region?->city->province->id,
                'title'=> $this->region?->city->province->title,
                'cities' => $this->region?->city->province->cities
            ],
            "city" => [
                'id'=> $this->region?->city->id,
                'title'=> $this->region?->city->title,
                'regions' => $this->region?->city->regions
            ],
            "region" => $this->region,
            "customers" => $this->customers,
            "created_at" => explode(' ', (new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ', (new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
