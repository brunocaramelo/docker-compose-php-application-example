<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Authors\Services\AuthorService;
use Tests\RunSeed\RunSeed;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    use RunSeed;

    public function setUp()
    {
        parent::setUp();
        $this->runSeed();
    }

    public function testAllAuthors()
    {
        $authorService = new AuthorService();
        $this->assertEquals($authorService->getAll()->toArray([]), $this->returnListSeedResult());
    }

    public function testAuthorSuccess()
    {
        $authorService = new AuthorService();
        $idFind = 2;

        $this->assertEquals(
            $authorService->getById($idFind)->toArray([]),
            $this->returnListSeedResult()[1]
        );
    }
    /**
     * @expectedException         \App\Domain\Authors\Exceptions\AuthorNotFoundException
     * @expectedExceptionMessage Autor não encontrado
     */
    public function testAuthorFailNotFound()
    {
        $authorService = new AuthorService();
        $idFind = 10;
        $authorService->getById($idFind)->toArray([]);
    }

    public function testCreateAuthorSuccess()
    {
        $expected = ['name' => 'Tonhão'];

        $authorService = new AuthorService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Authors\Exceptions\AuthorEditException
     * @expectedExceptionMessage  Autor já cadastrado
     */
    public function testCreateAuthorFailExists()
    {
        $expected = ['name' => 'Clenir Bellezi de Oliveira'];

        $authorService = new AuthorService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }

    public function testUpdateAuthorSuccess()
    {
        $expected = [
            'id' => '2',
            'name' => 'Tonhão'
        ];

        $authorService = new AuthorService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Authors\Exceptions\AuthorEditException
     * @expectedExceptionMessage  Preencha o Nome
     */
    public function testUpdateAuthorFailName()
    {
        $expected = [
            'id' => '2',
            'name' => null
        ];

        $authorService = new AuthorService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Authors\Exceptions\AuthorNotFoundException
     * @expectedExceptionMessage Autor não encontrado
     */
    public function testUpdateAuthorFailNotFound()
    {
        $expected = [
            'id' => '99',
            'name' => 'Tem um nome'
        ];

        $authorService = new AuthorService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }

    public function testShowBooks()
    {
        $authorEnt = new \App\Domain\Authors\Entities\AuthorEntity();
        $firstBook = $authorEnt->find(2)->books()->first();
        $expected = "Livro Falso 2";
        $this->assertEquals($firstBook->title, $expected);
    }

    private function returnListSeedResult()
    {
        return json_decode('[{"id":1,"name":"Clenir Bellezi de Oliveira"},{"id":2,"name":"Maria Falsa"},{"id":3,"name":"Regina Falsa"},{"id":4,"name":"Mauro Falso"}]',true);
    }
}
