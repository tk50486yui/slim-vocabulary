<?php

namespace app\Factories;

use app\Entities\ArticlesWordsEntity;
use app\Validators\Tables\ArticlesWordsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class ArticlesWordsFactory
{
    public function createFactory($data, $id)
    {
        $ArticlesWordsEntity = new ArticlesWordsEntity();        
        $ArticlesWordsValidator= new ArticlesWordsValidator();

        $ArticlesWordsEntity->populate($data);
       
        if (!$ArticlesWordsEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$ArticlesWordsValidator->foreignKey($ArticlesWordsEntity)){          
            throw new InvalidForeignKeyException();
        }
        if(!$ArticlesWordsValidator->dupKey($ArticlesWordsEntity)){          
            throw new DuplicateException();
        } 
     
        $ArticlesWordsEntity->setDefault();
        
        return $ArticlesWordsEntity->toArray();
    }
}
