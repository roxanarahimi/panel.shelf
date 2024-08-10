<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuCategoryResource extends JsonResource
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
            "skus" => SkuResource::collection($this->skus),
            "subsets" => SkuResource::collection($this->skus),
            "brands" => BrandSkuCategoryResource::collection($this->brands),
            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
