<?php

namespace App\Domain\Books\Validators;

use Validator;

class BookValidator
{
    private $messages = false;
    
    public function __construct()
    {
        $this->setMessages();
    }

    public function validateCreate($fields)
    {
        return $this->make($fields, [
                                        'title' => 'required',
                                        'price' => 'required|numeric',
                                        'isbn' => 'required|unique:books,isbn',
                                        'level' => 'required',
                                    ]);
    }

    public function validateUpdate($fields)
    {
        return $this->make($fields, [
                                        'title' => 'required',
                                        'price' => 'required|numeric',
                                        'isbn' => 'required|unique:books,isbn,'.$fields['id'],
                                        'level' => 'required',
                                    ]);
    }

    public function make($fields, $rules)
    {
        $validate =  Validator::make($fields, $rules, $this->messages);
        return $validate;
    }

    private function setMessages()
    {
        $this->messages = [
                            'title.required'=>'Preencha o Título',
                            'level.required'=>'Preencha o Nivel',
                            'isbn.required'=>'Preencha o ISBN',
                            'price.required'=>'Preencha o Preço',
                            'price.numeric'=>'Preço deve ser Numérico',
                            'isbn.unique'=>'Livro já cadastrado',
                            ];
    }
}
