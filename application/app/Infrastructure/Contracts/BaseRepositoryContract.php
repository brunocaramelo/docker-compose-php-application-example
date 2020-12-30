<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BaseRepositoryContract
{
    public function getAll();

    public function find($identify);
}
