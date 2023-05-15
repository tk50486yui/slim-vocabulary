<?php

namespace app\Factories;

use app\Entities\WordsEntity;
use app\Validators\Tables\WordsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;

class WordsFactory
{
    public function createFactory($data)
    {
        $WordsEntity = new WordsEntity();        
        $WordsValidator= new WordsValidator();

        $WordsEntity->populate($data);
        if (!$WordsEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$WordsValidator->validateForeignKey($WordsEntity)){
            throw new InvalidForeignKeyException();
        }
        return $WordsEntity;
    }
}
