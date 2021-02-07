<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\RunSeed\RunSeed;

class BookApiTest extends TestCase
{
    use RefreshDatabase;
    use RunSeed;

    public function setUp()
    {
        parent::setUp();
        $this->runSeed();
    }


    public function testGetOneBook()
    {
        $this->get('/api/v1/book/2', [ ])
                ->assertStatus(200)
                ->assertJson(
                    [
                        "data"=>
                        [
                            "id"=> 2,
                            "isbn"=> 7898592131058,
                            "title"=> "Livro Falso 2",
                            "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11603118CJ_resized_596x800.jpg",
                            "author"=> [
                                "Maria Falsa",
                                "Regina Falsa"
                            ],
                            "level"=> "Ensino médio",
                            "discipline"=> [
                                "Língua Portuguesa"
                            ],
                            "price"=> 219
                        ]

                    ]);
    }

    public function testGetOneBookFailNotFound()
    {
        $this->get('/api/v1/book/2000', [ ])
                ->assertStatus(404)
                ->assertJson([
                        "error"=> "Livro não encontrado",
                    ]);
    }

    public function testGetAllBooks()
    {
        $this->get('/api/v1/books/', [ ])
                ->assertStatus(200)
                ->assertJson(
                    [
                        "data"=> [
                            [
                                "id"=> 1,
                                "isbn"=> 7898592131010,
                                "title"=> "Livro Falso 1",
                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11603117CJ_resized_596x800.jpg",
                                "author"=> [
                                    "Clenir Bellezi de Oliveira"
                                ],
                                "level"=> "Ensino médio",
                                "discipline"=> [
                                    "Literatura",
                                    "Matemática"
                                ],
                                "price"=> 239
                            ],
                            [
                                "id"=> 2,
                                "isbn"=> 7898592131058,
                                "title"=> "Livro Falso 2",
                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11603118CJ_resized_596x800.jpg",
                                "author"=> [
                                    "Maria Falsa",
                                    "Regina Falsa"
                                ],
                                "level"=> "Ensino médio",
                                "discipline"=> [
                                    "Língua Portuguesa"
                                ],
                                "price"=> 219
                            ],
                            [
                                "id"=> 3,
                                "isbn"=> 7898592130853,
                                "title"=> "Livro Falso 3",
                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                "author"=> [
                                    "Mauro Falso"
                                ],
                                "level"=> "Ensino médio",
                                "discipline"=> [
                                    "Gramática",
                                    "Língua Portuguesa"
                                ],
                                "price"=> 249
                            ]
                        ]
            ]);
    }

    public function testPutSuccess()
    {
        $this->json('PUT', '/api/v1/book/2', [
                                                "isbn"=> 7898592180847,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    2
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(200)
                ->assertJson([
                        "message"=> "Book successfully edited",
                    ]);
    }

    public function testPutFailNotFound()
    {
        $this->json('PUT', '/api/v1/book/99', [
                                                "isbn"=> 7897572140847987897,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    2
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(404)
                ->assertJson([
                        "error"=> "Livro não encontrado",
                    ]);
    }

    public function testPutFailEdit()
    {
        $this->json('PUT', '/api/v1/book/2', [
                                                "isbn"=> null,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    2
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Preencha o ISBN",
                    ]);
    }

    public function testPutFailEditAuthorNotFound()
    {
        $this->json('PUT', '/api/v1/book/2', [
                                                "isbn"=> 4456456444654,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    999
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Autor não encontrado",
                    ]);
    }

    public function testPutFailEditDesciplineNotFound()
    {
        $this->json('PUT', '/api/v1/book/2', [
                                                "isbn"=> 4456456444654,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    1,
                                                    2
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2,
                                                    99
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Disciplina não encontrada",
                    ]);
    }

    public function testPostSuccess()
    {
        $this->json('POST', '/api/v1/book/', [
                                                "isbn"=> 4456456444654,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    1,
                                                    2
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(200)
                ->assertJson([
                        "message"=> "Successfully Created Book",
                    ]);
    }

    public function testPostFailEdit()
    {
        $this->json('POST', '/api/v1/book/',  [
                                                "isbn"=> 7898592131010,
                                                "title"=> "Livro Falso 1",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11603117CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    "Clenir Bellezi de Oliveira"
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    "Literatura",
                                                    "Matemática"
                                                ],
                                                "price"=> 239
                                            ])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Livro já cadastrado",
                    ]);
    }

    public function testPostFailEditAuthorNotFound()
    {
        $this->json('POST', '/api/v1/book/', [
                                                "isbn"=> 4456456444654,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    999
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Autor não encontrado",
                    ]);
    }

    public function testPostFailEditDesciplineNotFound()
    {
        $this->json('POST', '/api/v1/book/', [
                                                "isbn"=> 4456456444654,
                                                "title"=> "Livro Falso 3 Que mudei",
                                                "cover"=> "https://s3-us-west-2.amazonaws.com/catalogo.minhalivraria.com.br/files/uploads/11604000CJ_resized_596x800.jpg",
                                                "author"=> [
                                                    1,
                                                    2
                                                ],
                                                "level"=> "Ensino médio",
                                                "discipline"=> [
                                                    1,
                                                    2,
                                                    99
                                                ],
                                                "price"=> 219.40
                                            ])
                ->assertStatus(422)
                ->assertJson([
                        "error"=> "Disciplina não encontrada",
                    ]);
    }

    public function testDeleteFailNotFound()
    {
        $this->json("DELETE", '/api/v1/book/99', [])
                ->assertStatus(404)
                ->assertJson([
                        "error"=> "Livro não encontrado",
                    ]);
    }

    public function testDeleteSuccess()
    {
        $this->json("DELETE", '/api/v1/book/2', [])
                ->assertStatus(200)
                ->assertJson([
                        "data"=> "Book successfully removed",
                    ]);
    }


}
