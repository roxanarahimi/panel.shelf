<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerGradeScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sum = $this->sector?->score || 0 +$this->meterage+$this->product_variety +$this->product_layout +$this->equipment;
        $grade = '';
        if ($sum>= 21 && $sum <= 30){
           $grade =  'A';
        }
        if($sum>= 11 && $sum <= 20){
            $grade =  'B';
        }
        if($sum>= 1 && $sum <= 10){
            $grade =  'C';
        }
        return [
            "id" => (string)$this->id,
            "customer" => $this->customer,

            "sector" => $this->sector,
            "meterage" => $this->meterage,
            "product_variety" => $this->product_variety,
            "product_layout" => $this->product_layout,
            "equipment" => $this->equipment,
            "image" => $this->image,
            "grade"=> $grade,


            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];

    }
}
