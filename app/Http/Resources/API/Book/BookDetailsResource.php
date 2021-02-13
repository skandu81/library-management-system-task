<?php

namespace App\Http\Resources\API\Book;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailsResource extends JsonResource
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
            'author_name' => $this->author_name,
            'description' => $this->description,
            'added_by' => $this->added_by,
            'quantity' => $this->quantity,
        ];
    }
}
