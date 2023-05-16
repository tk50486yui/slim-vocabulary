<?php

namespace app\Factories;

use app\Entities\ArticlesTagsEntity;
use app\Validators\Tables\ArticlesTagsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class ArticlesTagsFactory
{
    public function createFactory($data, $id)
    {
        $ArticlesTagsEntity = new ArticlesTagsEntity();        
        $ArticlesTagsValidator= new ArticlesTagsValidator();

        $ArticlesTagsEntity->populate($data);
       
        if (!$ArticlesTagsEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$ArticlesTagsValidator->foreignKey($ArticlesTagsEntity)){          
            throw new InvalidForeignKeyException();
        }
        if(!$ArticlesTagsValidator->dupKey($ArticlesTagsEntity)){          
            throw new DuplicateException();
        } 
     
        $ArticlesTagsEntity->setDefault();
        
        return $ArticlesTagsEntity->toArray();
    }
}
