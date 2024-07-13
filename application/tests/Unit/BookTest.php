<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Books\Services\BookService;
use Tests\RunSeed\RunSeed;

class BookTest extends TestCase
{
    use RefreshDatabase;
    use RunSeed;

    public function setUp(): void
    {
        parent::setUp();
        $this->runSeed();
    }

    public function testAllBooks()
    {
        $authorService = new BookService();

        $this->assertEquals($authorService->getAll()->toArray([]), $this->returnListSeedResult());
    }

    public function testBookSuccess()
    {
        $authorService = new BookService();
        $idFind = 2;

        $this->assertEquals(
            $authorService->getById($idFind)->toArray([]),
            $this->returnListSeedResult()[1]
        );
    }
    /**
     * @expectedException         \App\Domain\Books\Exceptions\BookNotFoundException
     * @expectedExceptionMessage Livro não encontrado
     */
    public function testBookFailNotFound()
    {
        $this->expectException(\App\Domain\Books\Exceptions\BookNotFoundException::class);

        $authorService = new BookService();
        $idFind = 10;
        $authorService->getById($idFind)->toArray([]);
    }

    public function testCreateBookSuccess()
    {
        $expected = $this->returnListSeedResult()[0];
        $expected['isbn'] = '4644646464664';

        $mock = $expected;
        $mock['author'] = [1];
        $mock['discipline'] = [1,2];

        $authorService = new BookService();
        $last = $authorService->create($mock);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;

        $this->assertEquals($final, $expected);
    }

    /**
     * @expectedException         \App\Domain\Authors\Exceptions\AuthorNotFoundException
     * @expectedExceptionMessage  Autor não encontrado
     */
    public function testCreateBookFailAutor()
    {
        $this->expectException(\App\Domain\Authors\Exceptions\AuthorNotFoundException::class);

        $expected = $this->returnListSeedResult()[1];
        $expected['isbn'] = '4644646464664';

        $authorService = new BookService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException         \App\Domain\Disciplines\Exceptions\DisciplineNotFoundException
     * @expectedExceptionMessage  Disciplina não encontrada
     */
    public function testCreateBookFailDiscipline()
    {
        $this->expectException(\App\Domain\Disciplines\Exceptions\DisciplineNotFoundException::class);

        $expected = $this->returnListSeedResult()[1];
        $expected['isbn'] = '4644646464664';
        $expected['author'] = [1];

        $authorService = new BookService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }

    /**
     * @expectedException         \App\Domain\Books\Exceptions\BookEditException
     * @expectedExceptionMessage  Livro já cadastrado
     */
    public function testCreateBookFailExists()
    {
        $this->expectException(\App\Domain\Books\Exceptions\BookEditException::class);

        $expected = $this->returnListSeedResult()[1];

        $authorService = new BookService();
        $last = $authorService->create($expected);
        $final = $authorService->getById($last->id)->toArray([]);
        $expected['id'] = $last->id;
        $this->assertEquals($final, $expected);
    }

    public function testUpdateBookSuccess()
    {
        $expected = $this->returnListSeedResult()[0];
        $expected['isbn'] = '4644646464664';

        $mock = $expected;
        $mock['author'] = [1];
        $mock['discipline'] = [1,2];

        $authorService = new BookService();
        $authorService->update($expected['id'], $mock);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }

    /**
     * @expectedException         \App\Domain\Books\Exceptions\BookEditException
     * @expectedExceptionMessage  Preencha o ISBN
     */
    public function testUpdateBookFailName()
    {
        $this->expectException(\App\Domain\Books\Exceptions\BookEditException::class);

        $expected = $this->returnListSeedResult()[0];
        $expected['isbn'] = null;

        $mock = $expected;
        $mock['author'] = [1];
        $mock['discipline'] = [1,2];

        $authorService = new BookService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];
        $this->assertEquals($final, $expected);
    }
    /**
     * @expectedException          App\Domain\Books\Exceptions\BookNotFoundException
     * @expectedExceptionMessage  Livro não encontrado
     */
    public function testUpdateBookFailNotFound()
    {
        $this->expectException(\App\Domain\Books\Exceptions\BookNotFoundException::class);

        $expected = $this->returnListSeedResult()[0];
        $expected['id'] = 99;
        $expected['isbn'] = 88899789789;

        $mock = $expected;
        $mock['author'] = [1];
        $mock['discipline'] = [1,2];

        $authorService = new BookService();
        $authorService->update($expected['id'], $expected);
        $final = $authorService->getById($expected['id'])->toArray([]);
        $expected['id'] = $expected['id'];

        $this->assertEquals($final, $expected);
    }

    public function testExcludeBookSuccess()
    {
        $userService = new BookService();
        $userService->remove(2);

        $this->assertEquals(true, true);
    }

    /**
     * @expectedException         \App\Domain\Books\Exceptions\BookNotFoundException
     * @expectedExceptionMessage Livro não encontrado
     */
    public function testExcludeBookFailNotFind()
    {
        $this->expectException(\App\Domain\Books\Exceptions\BookNotFoundException::class);

        $userService = new BookService();
        $userService->remove(99);
    }

    public function testShowBookScope()
    {
        $authorEnt = new \App\Domain\Books\Entities\BookEntity();
        $firstBook = $authorEnt->active()->first();
        $expected = "Livro Falso 1";
        $this->assertEquals($firstBook->title, $expected);
    }

    private function returnListSeedResult()
    {
        return json_decode('[{"id":1,"isbn":"7898592131010","title":"Livro Falso 1","cover":"https:\/\/s3-us-west-2.amazonaws.com\/catalogo.minhalivraria.com.br\/files\/uploads\/11603117CJ_resized_596x800.jpg","author":["Clenir Bellezi de Oliveira"],"level":"Ensino m\u00e9dio","discipline":["Literatura","Matem\u00e1tica"],"price":"239"},{"id":2,"isbn":"7898592131058","title":"Livro Falso 2","cover":"https:\/\/s3-us-west-2.amazonaws.com\/catalogo.minhalivraria.com.br\/files\/uploads\/11603118CJ_resized_596x800.jpg","author":["Maria Falsa","Regina Falsa"],"level":"Ensino m\u00e9dio","discipline":["L\u00edngua Portuguesa"],"price":"219"},{"id":3,"isbn":"7898592130853","title":"Livro Falso 3","cover":"https:\/\/s3-us-west-2.amazonaws.com\/catalogo.minhalivraria.com.br\/files\/uploads\/11604000CJ_resized_596x800.jpg","author":["Mauro Falso"],"level":"Ensino m\u00e9dio","discipline":["Gram\u00e1tica","L\u00edngua Portuguesa"],"price":"249"}]',true);
    }
}
