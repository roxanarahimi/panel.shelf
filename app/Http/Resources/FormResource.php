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
        if($this->customer->scores){
        $scores = new CustomerGradeScoreResource($this->customer->scores);
        $grade=$scores->grade;
        }else{
            $grade = '';
        }
        return [
            "id" => (string)$this->id,
            "sections" => FormSectionResource::collection($this->sections),
            "visitor" => $this->visitor,
            "customer" => $this->customer,
            "customerGrade" => $grade,
            "description" => $this->description,

            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
