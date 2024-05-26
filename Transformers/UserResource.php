<?php

namespace Modules\Auth\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
      
        return array_merge(
            // start of object
            [
                'username' => $this->username,
                'verified' =>  $this->is_verified,
            ],
            // more extra data.
            $this->extra,
            // add datates
            [
                'type' => $this->type,
                'created_at'   => $this->created_at,
                'update_at' => $this->update_at
            ]
        );
    }
}
