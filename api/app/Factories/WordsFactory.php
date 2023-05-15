<?php

namespace app\Factories;

use app\Entities\WordsEntity;
use app\Validators\Tables\WordsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

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
        if(!$WordsValidator->dupName($WordsEntity->ws_name)){          
            throw new DuplicateException();
        }
        
        $WordsEntity->setDefault();
     
        return $WordsEntity->toArray();
    }
}
