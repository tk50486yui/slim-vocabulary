<?php

namespace app\Factories;

use app\Entities\TagsEntity;
use app\Validators\Tables\TagsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class TagsFactory
{
    public function createFactory($data, $id)
    {
        $TagsEntity = new TagsEntity();        
        $TagsValidator= new TagsValidator();       

        $TagsEntity->populate($data);
        
        if (!$TagsEntity->validate()) {
            throw new InvalidDataException();
        }
      
        if(!$TagsValidator->foreignKey($TagsEntity)){          
            throw new InvalidForeignKeyException();
        }
     
        if(!$TagsValidator->dupName($TagsEntity, $id)){                 
            throw new DuplicateException();
        }

        if($id !== null && !$TagsValidator->validateTree($TagsEntity, $id)){
            throw new InvalidDataException();
        }    
        
        $TagsEntity->setDefault();
     
        return $TagsEntity->toArray();
    }
}
