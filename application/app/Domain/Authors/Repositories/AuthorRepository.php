<?php

namespace App\Domain\Authors\Repositories;

use App\Domain\Authors\Entities\AuthorEntity;
use App\Infrastructure\Contracts\BaseRepositoryContract;

class AuthorRepository implements BaseRepositoryContract
{
    private $author = null;

    public function __construct(AuthorEntity $author)
    {
        $this->author = $author;
    }

    public function getAll()
    {
        return $this->author->active()->get();
    }

    public function find($identify)
    {
        return $this->author->find($identify);
    }

    public function create($data)
    {
        return $this->author->create($data);
    }

    public function update($identify, $data)
    {
        $authorSave = $this->author->find($identify);
        return $authorSave->fill($data)->save();
    }
}
