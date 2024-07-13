<?php

namespace App\Domain\Authors\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Domain\Authors\Resources\AuthorResource;

class AuthorListResource extends JsonResource
{
    public function toArray($request)
    {
        return AuthorResource::collection($this)->toArray(new \Illuminate\Http\Request());
    }
}
