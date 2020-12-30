<?php
namespace App\Domain\Books\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'cover' => $this->cover,
            'author' => $this->authors()->get()->map(function ($author) {
                return $author->name;
            })->toArray(),
            'level' => $this->level_name,
            'discipline' => $this->disciplines()->get()->map(function ($discipline) {
                return $discipline->name;
            })->toArray(),
            'price' => $this->price,
        ];
    }
}
