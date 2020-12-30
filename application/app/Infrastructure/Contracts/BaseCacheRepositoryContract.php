<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Infrastructure\Contracts\BaseRepositoryContract;

interface BaseCacheRepositoryContract
{
    public function __construct(BaseRepositoryContract $repository);
    
    public function getAll();

    public function find($identify);
}
