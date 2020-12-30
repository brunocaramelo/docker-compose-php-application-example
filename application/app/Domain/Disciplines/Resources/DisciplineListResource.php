<?php

namespace App\Domain\Disciplines\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Domain\Disciplines\Resources\DisciplineResource;

class DisciplineListResource extends JsonResource
{
    public function toArray($request)
    {
        return DisciplineResource::collection($this)->toArray([]);
    }
}
