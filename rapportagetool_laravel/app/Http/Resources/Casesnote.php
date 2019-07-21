<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Casesnote extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'body' => $this->body,
            'created_by' => $this->creator_id,
        ];
    }

}
