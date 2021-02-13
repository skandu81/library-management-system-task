<?php

namespace App\Http\Resources\API\Book;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookListResource extends JsonResource
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
            'publisher' => $this->publisher ? $this->publisher->name : 'Not available',
            'availability' => $this->quantity > 0 ? true : false,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y')
        ];
    }
}
