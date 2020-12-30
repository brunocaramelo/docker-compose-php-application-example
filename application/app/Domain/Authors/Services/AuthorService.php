<?php

namespace App\Domain\Authors\Services;

use App\Domain\Authors\Validators\AuthorValidator;
use App\Domain\Authors\Exceptions\AuthorEditException;
use App\Domain\Authors\Exceptions\AuthorNotFoundException;
use App\Domain\Authors\Entities\AuthorEntity;
use App\Domain\Authors\Repositories\AuthorRepository;
use App\Domain\Authors\Repositories\AuthorCacheRepository;

use App\Domain\Authors\Resources\AuthorListResource;
use App\Domain\Authors\Resources\AuthorResource;

class AuthorService
{
    private $authorRepo;
    
    public function __construct()
    {
        $this->authorRepo = new AuthorRepository(new AuthorEntity());
    }

    public function getAll(): AuthorListResource
    {
        $userCache = new AuthorCacheRepository($this->authorRepo);
        return new AuthorListResource($userCache->getAll());
    }

    public function create(array $data): AuthorEntity
    {
        $validate = new AuthorValidator();
        $validation = $validate->validateCreate($data);
        
        if ($validation->fails() === true) {
            throw new AuthorEditException(implode("\n", $validation->errors()->all()));
        }
        $userCache = new AuthorCacheRepository($this->authorRepo);
        return $userCache->create($data);
    }

    public function update($identify, array $data): bool
    {
        $data['id'] = $identify;
        $validate = new AuthorValidator();
        $validation = $validate->validateUpdate($data);
        
        if ($validation->fails()) {
            throw new AuthorEditException(implode("\n", $validation->errors()->all()));
        }
        
        if ($this->authorRepo->find($identify) === null) {
            throw new AuthorNotFoundException('Autor não encontrado');
        }
        $userCache = new AuthorCacheRepository($this->authorRepo);
        return $userCache->update($identify, $data);
    }

    public function getById($identify): AuthorResource
    {
        $authorCache = new AuthorCacheRepository($this->authorRepo);
        $found = $authorCache->find($identify);
        if ($found === null) {
            throw new AuthorNotFoundException('Autor não encontrado');
        }
        return new AuthorResource($found);
    }
}
