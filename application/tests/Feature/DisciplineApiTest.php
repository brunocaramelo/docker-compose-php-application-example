<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\RunSeed\RunSeed;

class DisciplineApiTest extends TestCase
{
    use RefreshDatabase;
    use RunSeed;

    public function setUp()
    {
        parent::setUp();
        $this->runSeed();
    }


    public function testGetOneAuthor()
    {
        $this->get('/api/v1/discipline/2', [ ])
                ->assertStatus(200)
                ->assertJson(
                    [
                        "data"=>
                            [
                                "id"=> 2,
                                "name"=> "Matemática",
                            ]
                    ]);
    }

    public function testGetOneAuthorNotFound()
    {
        $this->get('/api/v1/discipline/2000', [ ])
                ->assertStatus(404)
                ->assertJson([
                    "error"=> "Disciplina não encontrada",
                ]);
    }

    public function testGetAllAuthors()
    {
        $this->get('/api/v1/disciplines/', [ ])
                ->assertStatus(200)
                ->assertJson(
                    [
                        "data"=>[
                            [
                                "id"=> 1,
                                "name"=> "Literatura",
                            ],
                            [
                                "id"=> 2,
                                "name"=> "Matemática",
                            ],
                            [
                                "id"=> 3,
                                "name"=> "Língua Portuguesa",
                            ],
                            [
                                "id"=> 4,
                                "name"=> "Gramática",
                            ],
                        ]
            ]);
    }

    public function testPutSuccess()
    {
        $this->json('PUT', '/api/v1/discipline/2', ['name' => 'Religiao'])
                ->assertStatus(200)
                ->assertJson([
                        "message"=> "Discipline successfully edited",
                    ]);
    }

    public function testPutFailNotFound()
    {
        $this->json('PUT', '/api/v1/discipline/99', ['name' => 'Geografia'])
                ->assertStatus(404)
                ->assertJson([
                        "error"=> "Disciplina não encontrada",
                    ]);
    }

    public function testPutFailEdit()
    {
        $this->json('PUT', '/api/v1/discipline/2', ['name' => null])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Preencha o Nome",
                    ]);
    }

    public function testPostSuccess()
    {
        $this->json('POST', '/api/v1/discipline/', ['name' => 'Geografia'])
                ->assertStatus(200)
                ->assertJson([
                        "message"=> "Successfully Created Discipline",
                    ]);
    }

    public function testPostFailEdit()
    {
        $this->json('POST', '/api/v1/discipline/', ['name' => "Literatura"])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Disciplina já cadastrada",
                    ]);
    }

}
