<?php

namespace App\Domain\Books\Services;

use App\Domain\Books\Validators\BookValidator;
use App\Domain\Books\Exceptions\BookEditException;
use App\Domain\Books\Exceptions\BookNotFoundException;
use App\Domain\Books\Entities\BookEntity;
use App\Domain\Books\Repositories\BookRepository;
use App\Domain\Books\Repositories\BookCacheRepository;

use App\Domain\Books\Resources\BookListResource;
use App\Domain\Books\Resources\BookResource;

use App\Domain\Authors\Services\AuthorService;
use App\Domain\Disciplines\Services\DisciplineService;

class BookService
{
    private $bookRepo;
    
    public function __construct()
    {
        $this->bookRepo = new BookRepository(new BookEntity());
    }

    public function getAll(): BookListResource
    {
        $userCache = new BookCacheRepository($this->bookRepo);
        return new BookListResource($userCache->getAll());
    }

    public function create(array $data): BookEntity
    {
        $data['level_name'] = $data['level'];

        $validate = new BookValidator();
        $validation = $validate->validateCreate($data);
        
        if ($validation->fails() === true) {
            throw new BookEditException(implode("\n", $validation->errors()->all()));
        }
        
        $this->verifyAuthors($data['author']);
        $this->verifyDiscliplines($data['discipline']);

        $userCache = new BookCacheRepository($this->bookRepo);
        $bookInstance = $userCache->create($data);
        return $bookInstance;
    }
    
    public function update($identify, array $data): bool
    {
        $data['level_name'] = $data['level'];
        $data['id'] = $identify;

        $validate = new BookValidator();
        $validation = $validate->validateUpdate($data);
        
        if ($validation->fails()) {
            throw new BookEditException(implode("\n", $validation->errors()->all()));
        }
        if ($this->bookRepo->find($identify) === null) {
            throw new BookNotFoundException('Livro não encontrado');
        }

        $this->verifyAuthors($data['author']);
        $this->verifyDiscliplines($data['discipline']);

        $userCache = new BookCacheRepository($this->bookRepo);
        return $userCache->update($identify, $data);
    }

    public function getById($identify): BookResource
    {
        $authorCache = new BookCacheRepository($this->bookRepo);
        $found = $authorCache->find($identify);
        if ($found === null) {
            throw new BookNotFoundException('Livro não encontrado');
        }
        return new BookResource($found);
    }

    private function verifyAuthors(array $authors)
    {
        $authorService = new AuthorService();
        foreach ($authors as $authorId) {
            $authorService->getById($authorId);
        }
    }
    
    private function verifyDiscliplines(array $disciplines)
    {
        $disciplineService = new DisciplineService();
        foreach ($disciplines as $disciplineId) {
            $disciplineService->getById($disciplineId);
        }
    }

    public function remove($identify)
    {
        $userCache = new BookCacheRepository($this->bookRepo);
        $found = $userCache->find($identify);
        
        if ($found === null) {
            throw new BookNotFoundException('Livro não encontrado');
        }
        return $userCache->remove($identify);
    }
}
