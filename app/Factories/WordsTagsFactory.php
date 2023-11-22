<?php

namespace app\Factories;

use app\Entities\WordsTagsEntity;
use app\Validators\Tables\WordsTagsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class WordsTagsFactory
{
    public function createFactory($data, $id)
    {
        $WordsTagsEntity = new WordsTagsEntity();        
        $WordsTagsValidator= new WordsTagsValidator();

        $WordsTagsEntity->populate($data);
       
        if (!$WordsTagsEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$WordsTagsValidator->foreignKey($WordsTagsEntity)){          
            throw new InvalidForeignKeyException();
        }
        if(!$WordsTagsValidator->dupKey($WordsTagsEntity)){          
            throw new DuplicateException();
        } 
     
        $WordsTagsEntity->setDefault();
        
        return $WordsTagsEntity->toArray();
    }
}
