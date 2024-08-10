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
            "mobile" => $this->mobile,
            "phone" => $this->phone,
            "active" => (boolean)$this->active,
            "province" => $this->region?->city?->province,
            "city" => $this->region?->city,
            "region" => $this->region,
            "sector" => $this->sector,
            "address" => $this->address,
            "path" => $this->path,
            "path_code" => $this->path_code,
            "path_description" => $this->path_description,
            "scores" => new CustomerGradeScoreResource($this->scores),
            "forms" =>  CustomerGradeScoreResource::collection($this->forms),
            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
