<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $thumb = $this->image ? str_replace('.png','_thumb.png', $this->image) : '';
        return [
            "id" => (string)$this->id,
            "value" => (string)$this->id,
            "index" => $this->index,
            "product_category_id" => $this->product_category_id,
            "image" => $this->image,
            "thumb" => $thumb,
            "title" => $this->title,
            "title_en" => $this->title_en,
            "subTitle" => $this->subTitle,
            "flavor" => $this->flavor,
            "flavor_en" => $this->flavor_en,
            "ingredients" => $this->ingredients,
            "link" => $this->link,
            "stock" => $this->stock,
            "active" => (boolean)$this->active,
            "text" => $this->text,
            "category" => [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'active' => $this->category->active,
            ],
            "features" => $this->features,
            "price" => $this->price,
            "off" => $this->off,
            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
