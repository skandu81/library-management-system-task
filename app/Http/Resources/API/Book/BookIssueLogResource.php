<?php

namespace App\Http\Resources\API\Book;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookIssueLogResource extends JsonResource
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
            'user' => $this->user ? $this->user->name : 'Not Found',
            'book' => $this->book ? $this->book->title : 'Not Found',
            'issued_at' => Carbon::parse($this->issued_at)->toDateTimeString(),
            'return_at' => $this->return_at ? Carbon::parse($this->return_at)->toDateTimeString() : null,
        ];
    }
}
