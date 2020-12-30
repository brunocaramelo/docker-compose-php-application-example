<?php

namespace App\Domain\Books\Repositories;

use App\Domain\Books\Entities\BookEntity;
use App\Infrastructure\Contracts\BaseRepositoryContract;

class BookRepository implements BaseRepositoryContract
{
    private $book = null;

    public function __construct(BookEntity $book)
    {
        $this->book = $book;
    }

    public function getAll()
    {
        return $this->book->all();
    }

    public function find($identify)
    {
        return $this->book->find($identify);
    }

    public function create($data)
    {
        $bookCreate = $this->book->create($data);

        $this->syncAuthors($bookCreate, $data['author']);
        $this->syncDisciplines($bookCreate, $data['discipline']);

        return $bookCreate;
    }

    public function update($identify, $data)
    {
        $bookSave = $this->book->find($identify);
        $statusUpdate = $bookSave->fill($data)->save();

        $this->syncAuthors($bookSave, $data['author']);
        $this->syncDisciplines($bookSave, $data['discipline']);

        return $statusUpdate;
    }

    public function syncAuthors(BookEntity $book, $lisAuthors)
    {
        return $book->authors()->sync($lisAuthors);
    }
    
    public function syncDisciplines(BookEntity $book, $lisDisciplines)
    {
        return $book->disciplines()->sync($lisDisciplines);
    }

    public function remove($identify)
    {
        $bookSave = $this->book->find($identify);
        return $bookSave->fill([ 'status' => '0' ])->save();
    }
}
