<?php

namespace app\Factories;

use app\Entities\WordsEntity;
use app\Validators\tables\WordsValidator;
use libs\Exceptions\InvalidDataException;

class WordsFactory
{
    public function createFactory($data)
    {
        $WordsEntity = new WordsEntity();        
        $WordsValidator= new WordsValidator();

        $WordsEntity->populate($data);
        if (!$WordsEntity->validate()) {
            throw new InvalidDataException('Invalid input data');
        }

        return $WordsEntity;
    }
}
