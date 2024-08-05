<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            "code" => $this->code,
            "name" => $this->name,
            "shop_name" => $this->shop_name,
            "mobile" => $this->mobile,
            "phone" => $this->phone,
            "active" => (boolean)$this->active,
            "province" => $this->sector->region->city->province,
            "city" => $this->sector->region->city,
            "region" => $this->sector->region,
            "sector" => $this->sector,
            "address" => $this->address,
            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
