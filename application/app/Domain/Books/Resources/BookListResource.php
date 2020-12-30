<?php

namespace App\Domain\Books\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Domain\Books\Resources\BookResource;

class BookListResource extends JsonResource
{
    public function toArray($request)
    {
        return BookResource::collection($this)->toArray([]);
    }
}
