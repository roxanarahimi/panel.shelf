<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSectionResource extends JsonResource
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

            "face" => $this->face,
            "presence" => $this->presence,
            "space" => $this->space,
            "layout" => $this->layout,
            "expire_date" => $this->expire_date,
            "label_price" => $this->label_price,
            "sale_price" => $this->sale_price,
            "distribute_price" => $this->distribute_price,

            "skuCategory" => new SkuCategoryResource($this->skuCategory),
            "brand" => new BrandResource($this->brand),
            "skus" => FormSectionSkuResource::collection($this->skus),

            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
