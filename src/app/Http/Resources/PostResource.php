<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'user_name' => $this->user ? $this->user->name : 'Anonymous',
            'user_username' => $this->user ? $this->user->username : 'anonymous',
            'tags' => $this->tags,
        ];
    }
}
