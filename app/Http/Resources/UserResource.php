<?php

namespace App\Http\Resources;

use App\Http\Controllers\DateController;
use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        switch ($this->gender) {
            case 'female':
            {
                $gender = 'خانم';
                break;
            }
            case 'male':
            {
                $gender = 'آقا';
                break;
            }
            default:
            {
                $gender = 'نامعلوم';
                break;
            }
        }

        return [
            "id" => (string)$this->id,
            "name" => $this->name,
            "email" => $this->email,
            "last_activity_at" => $this->last_activity,

             "mobile" => $this->mobile,
            "gender" => $gender,
            "avatar" => $this->avatar,


            "scope" => $this->scope,

//            "expires_at" => $exp,

            "created_at" => explode(' ',(new DateController)->toPersian($this->created_at))[0],
            "updated_at" => explode(' ',(new DateController)->toPersian($this->updated_at))[0],
        ];
    }
}
