<?php

namespace App\Domain\Disciplines\Services;

use Illuminate\Support\Facades\Hash;

use App\Domain\Disciplines\Validators\DisciplineValidator;
use App\Domain\Disciplines\Exceptions\DisciplineEditException;
use App\Domain\Disciplines\Exceptions\DisciplineNotFoundException;
use App\Domain\Disciplines\Entities\DisciplineEntity;
use App\Domain\Disciplines\Repositories\DisciplineRepository;
use App\Domain\Disciplines\Repositories\DisciplineCacheRepository;

use App\Domain\Disciplines\Resources\DisciplineListResource;
use App\Domain\Disciplines\Resources\DisciplineResource;

class DisciplineService
{
    private $disciplineRepo;
    
    public function __construct()
    {
        $this->disciplineRepo = new DisciplineRepository(new DisciplineEntity());
    }

    public function getAll(): DisciplineListResource
    {
        $userCache = new DisciplineCacheRepository($this->disciplineRepo);
        return new DisciplineListResource($userCache->getAll());
    }

    public function create(array $data): DisciplineEntity
    {
        $validate = new DisciplineValidator();
        $validation = $validate->validateCreate($data);
        
        if ($validation->fails() === true) {
            throw new DisciplineEditException(implode("\n", $validation->errors()->all()));
        }
        
        $userCache = new DisciplineCacheRepository($this->disciplineRepo);
        return $userCache->create($data);
    }

    public function update($identify, array $data): bool
    {
        $data['id'] = $identify;
        $validate = new DisciplineValidator();
        $validation = $validate->validateUpdate($data);
        
        if ($validation->fails()) {
            throw new DisciplineEditException(implode("\n", $validation->errors()->all()));
        }
        
        if ($this->disciplineRepo->find($identify) === null) {
            throw new DisciplineNotFoundException('Disciplina não encontrada');
        }
        $userCache = new DisciplineCacheRepository($this->disciplineRepo);
        return $userCache->update($identify, $data);
    }

    public function getById($identify): DisciplineResource
    {
        $disciplineCache = new DisciplineCacheRepository($this->disciplineRepo);
        $found = $disciplineCache->find($identify);
        if ($found === null) {
            throw new DisciplineNotFoundException('Disciplina não encontrada');
        }
        return new DisciplineResource($found);
    }
}
