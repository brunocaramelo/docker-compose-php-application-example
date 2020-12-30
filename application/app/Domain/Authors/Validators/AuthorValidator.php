<?php

namespace App\Domain\Authors\Validators;

use Validator;

class AuthorValidator
{
    private $messages = false;
    
    public function __construct()
    {
        $this->setMessages();
    }

    public function validateCreate($fields)
    {
        return $this->make($fields, [
                                        'name' => 'required|unique:authors,name',
                                    ]);
    }

    public function validateUpdate($fields)
    {
        return $this->make($fields, [
                                        'name' => 'required|unique:authors,name,'.$fields['id'],
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
                            'name.required'=>'Preencha o Nome',
                            'name.unique'=>'Autor já cadastrado',
                            ];
    }
}
