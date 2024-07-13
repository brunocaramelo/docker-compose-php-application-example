<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\RunSeed\RunSeed;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;
    use RunSeed;

    public function setUp(): void
    {
        parent::setUp();
        $this->runSeed();
    }


    public function testGetOneAuthor()
    {
        $this->get('/api/v1/author/2', [ ])
                ->assertStatus(200)
                ->assertJson(
                    [
                        "data"=>
                            [
                                "id"=> 2,
                                "name"=> "Maria Falsa",
                            ]
                    ]);
    }

    public function testGetOneNotFound()
    {
        $this->get('/api/v1/author/200', [ ])
                ->assertStatus(404)
                ->assertJson([
                    "error"=> "Autor não encontrado",
                ]);
    }

    public function testGetAllAuthors()
    {
        $this->get('/api/v1/authors/', [ ])
                ->assertStatus(200)
                ->assertJson(
                    [
                        "data"=>[
                            [
                                "id"=> 1,
                                "name"=> "Clenir Bellezi de Oliveira",
                            ],
                            [
                                "id"=> 2,
                                "name"=> "Maria Falsa",
                            ],
                            [
                                "id"=> 3,
                                "name"=> "Regina Falsa",
                            ],
                            [
                                "id"=> 4,
                                "name"=> "Mauro Falso",
                            ],
                        ]
            ]);
    }

    public function testPutSuccess()
    {
        $this->json('PUT', '/api/v1/author/2', ['name' => 'Sally'])
                ->assertStatus(200)
                ->assertJson([
                        "message"=> "Author Edited successfully",
                    ]);
    }

    public function testPutFailNotFound()
    {
        $this->json('PUT', '/api/v1/author/99', ['name' => 'Sally'])
                ->assertStatus(404)
                ->assertJson([
                        "error"=> "Autor não encontrado",
                    ]);
    }

    public function testPutFailEdit()
    {
        $this->json('PUT', '/api/v1/author/2', ['name' => null])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Preencha o Nome",
                    ]);
    }

    public function testPostSuccess()
    {
        $this->json('POST', '/api/v1/author/', ['name' => 'Sally'])
                ->assertStatus(200)
                ->assertJson([
                        "message"=> "Author Created successfully",
                    ]);
    }

    public function testPostFailEdit()
    {
        $this->json('POST', '/api/v1/author/', ['name' => "Maria Falsa"])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Autor já cadastrado",
                    ]);
    }

}
