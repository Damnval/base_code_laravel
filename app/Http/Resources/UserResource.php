<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $this->whenLoaded implement this to break loop in resource.
        // e.g. UserResource has an relationship address and this address
        // uses an addressResource. However in this addressResource a 'user' Relationship
        // is being called using UserResource again which results into a loop

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'updated_at' => $this->updated_at,
            'address' => new AddressResource($this->whenLoaded('address'))
        ];
    }
}
