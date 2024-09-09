<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
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
//            "visitor" => new VisitorResource($this->visitor),
//            "customer" => new CustomerResource($this->customer),
            "sections" => FormSectionResource::collection($this->sections),
            "visitor" => $this->visitor,
            "customer" => $this->customer,
//            "sections" => $this->sections,
            "description" => $this->description,

            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
