<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSectionSkuResource extends JsonResource
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
            "sku" => $this->sku,
            "face" => $this->face,
            "presence" => $this->presence,
            "expire_date" => $this->expire_date,
            "label_price" => number_format($this->label_price),
            "sale_price" => number_format($this->sale_price),
            "distribute_price" => number_format($this->distribute_price),

            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
