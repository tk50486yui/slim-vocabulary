<?php

namespace app\Factories;

use app\Entities\ArticlesEntity;
use app\Validators\Tables\ArticlesValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;

class ArticlesFactory
{
    public function createFactory($data, $id)
    {
        $ArticlesEntity = new ArticlesEntity();        
        $ArticlesValidator= new ArticlesValidator();

        $ArticlesEntity->populate($data);
       
        if (!$ArticlesEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$ArticlesValidator->foreignKey($ArticlesEntity)){          
            throw new InvalidForeignKeyException();
        }      
        
        $ArticlesEntity->setDefault();
     
        return $ArticlesEntity->toArray();
    }
}
