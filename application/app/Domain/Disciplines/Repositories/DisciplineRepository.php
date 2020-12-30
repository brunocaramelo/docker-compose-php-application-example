<?php

namespace App\Domain\Disciplines\Repositories;

use App\Domain\Disciplines\Entities\DisciplineEntity;
use App\Infrastructure\Contracts\BaseRepositoryContract;

class DisciplineRepository implements BaseRepositoryContract
{
    private $discipline;

    public function __construct(DisciplineEntity $discipline)
    {
        $this->discipline = $discipline;
    }

    public function getAll()
    {
        return $this->discipline->active()->get();
    }

    public function find($identify)
    {
        return $this->discipline->find($identify);
    }

    public function create($data)
    {
        return $this->discipline->create($data);
    }

    public function update($identify, $data)
    {
        $disciplineSave = $this->discipline->find($identify);
        return $disciplineSave->fill($data)->save();
    }
}
