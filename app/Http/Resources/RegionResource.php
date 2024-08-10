<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => (string)$this->id,
            "title" => $this->title,
            "active" => (boolean)$this->active,

//            "province" => new ProvinceResource($this->city->province),
            "province" => [$this->city->province,
                'cities'=>$this->city->province->cities],
//            "city" => new CityResource($this->city),
            "city" => $this->city,
//            "sectors" => $this->sectors,
            "customers" => $this->customers,
            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
