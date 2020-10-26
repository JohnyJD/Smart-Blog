<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
          'data' => [
              'post_id' => $this->id,
              'title' => $this->title,
              'views' => $this->views,
              'slug' => $this->slug,
              'slug_image' => $this->slug_image,
              'text' => $this->text,
              'created_at' => $this->created_at->format('M d, Y'),
              'user' => $this->user,
              'categories' => $this->categories,
              'comments' => $this->comments,
          ],
          'links' => [
              'self' => $this->path(),
          ]
        ];
    }
}
