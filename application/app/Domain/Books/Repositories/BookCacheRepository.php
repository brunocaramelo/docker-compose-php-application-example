<?php

namespace App\Domain\Books\Repositories;

use Illuminate\Support\Facades\Cache;

use App\Infrastructure\Contracts\BaseCacheRepositoryContract;

use App\Infrastructure\Contracts\BaseRepositoryContract;

class BookCacheRepository implements BaseCacheRepositoryContract
{
    protected $books;

    public function __construct(BaseRepositoryContract $books)
    {
        $this->books = $books;
    }

    public function getAll()
    {
        return Cache::remember('book.list', 10, function () {
            return $this->books->getAll();
        });
    }
  
    public function find($identify)
    {
        return Cache::remember("book.{$identify}", 60, function () use ($identify) {
            return $this->books->find($identify);
        });
    }

    public function update($identify, $data)
    {
        $updateResult = $this->books->update($identify, $data);
        Cache::forget("book.{$identify}");
        Cache::forget("book.list");
        return $updateResult;
    }
    
    public function create($data)
    {
        $createResult = $this->books->create($data);
        Cache::forget("book.list");
        return $createResult;
    }

    public function remove($identify)
    {
        $createResult = $this->books->remove($identify);
        Cache::forget("book.{$identify}");
        Cache::forget("book.list");
        return $createResult;
    }
}
