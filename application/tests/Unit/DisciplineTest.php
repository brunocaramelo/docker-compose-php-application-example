<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Disciplines\Services\DisciplineService;
use Tests\RunSeed\RunSeed;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;
    use RunSeed;

    public function setUp()
    {
        parent::setUp();
        $this->runSeed();
    }

    public function testAllDisciplines()
    {
        $authorService = new DisciplineService();

        $this->assertEquals($authorService->getAll()->toArray([]), $this->returnListSeedResult());
    }

    public function testDisciplineSuccess()
    {
        $authorService = new DisciplineService();
        $idFind = 2;

        $this->assertEquals(
            $authorService->getById($idFind)->toArray([]),
            $this->returnListSeedResult()[1]
        );
    }
    /**
     * @expectedException         \App\Domain\Disciplines\Exceptions\DisciplineNotFoundException
     * @expectedExceptionMessage Disciplina não encontrada
     */
    public function testDisciplineFailNotFound()
    {
        $authorService = new DisciplineService();
        $idFind = 10;
        $authorService->getById($idFind)->toArray([]);
    }

    public function testCreateDisciplineSuccess()
    {
        $expected = ['name' => 'Artes'];

        $authorService = new DisciplineService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Disciplines\Exceptions\DisciplineEditException
     * @expectedExceptionMessage  Disciplina já cadastrada
     */
    public function testCreateDisciplineFailExists()
    {
        $expected = ['name' => 'Literatura'];

        $authorService = new DisciplineService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }

    public function testUpdateDisciplineSuccess()
    {
        $expected = [
            'id' => '2',
            'name' => 'Tonhão'
        ];

        $authorService = new DisciplineService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Disciplines\Exceptions\DisciplineEditException
     * @expectedExceptionMessage  Preencha o Nome
     */
    public function testUpdateDisciplineFailName()
    {
        $expected = [
            'id' => '2',
            'name' => null
        ];

        $authorService = new DisciplineService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Disciplines\Exceptions\DisciplineNotFoundException
     * @expectedExceptionMessage Disciplina não encontrada
     */
    public function testUpdateDisciplineFailNotFound()
    {
        $expected = [
            'id' => '99',
            'name' => 'Tem um nome'
        ];

        $authorService = new DisciplineService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }

    public function testShowBooks()
    {
        $authorEnt = new \App\Domain\Disciplines\Entities\DisciplineEntity();
        $firstBook = $authorEnt->find(2)->books()->first();
        $expected = "Livro Falso 1";
        $this->assertEquals($firstBook->title, $expected);
    }

    private function returnListSeedResult()
    {
        return json_decode('[{"id":1,"name":"Literatura"},{"id":2,"name":"Matem\u00e1tica"},{"id":3,"name":"L\u00edngua Portuguesa"},{"id":4,"name":"Gram\u00e1tica"}]',true);
    }
}
