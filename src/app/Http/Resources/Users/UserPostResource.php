<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Tags\TagCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPostResource extends JsonResource
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'tags' => new TagCollection($this->tags),
        ];
    }
}
