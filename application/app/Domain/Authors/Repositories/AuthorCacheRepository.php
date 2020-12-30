<?php

namespace App\Domain\Authors\Repositories;

use Illuminate\Support\Facades\Cache;

use App\Infrastructure\Contracts\BaseCacheRepositoryContract;

use App\Infrastructure\Contracts\BaseRepositoryContract;

class AuthorCacheRepository implements BaseCacheRepositoryContract
{
    protected $authors;

    public function __construct(BaseRepositoryContract $authors)
    {
        $this->authors = $authors;
    }

    public function getAll()
    {
        return Cache::remember('author.list', 10, function () {
            return $this->authors->getAll();
        });
    }

  
    public function find($identify)
    {
        return Cache::remember("author.{$identify}", 60, function () use ($identify) {
            return $this->authors->find($identify);
        });
    }

    public function update($identify, $data)
    {
        $updateResult = $this->authors->update($identify, $data);
        Cache::forget("author.{$identify}");
        Cache::forget("author.list");
        return $updateResult;
    }
    
    public function create($data)
    {
        $createResult = $this->authors->create($data);
        Cache::forget("author.list");
        return $createResult;
    }
}
