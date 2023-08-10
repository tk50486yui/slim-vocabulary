<?php

namespace app\Factories;

use app\Entities\CategoriesEntity;
use app\Validators\Tables\CategoriesValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class CategoriesFactory
{
    public function createFactory($data, $id)
    {
        $CategoriesEntity = new CategoriesEntity();        
        $CategoriesValidator= new CategoriesValidator();       

        $CategoriesEntity->populate($data);
        
        if (!$CategoriesEntity->validate()) {        
            throw new InvalidDataException();
        }
      
        if(!$CategoriesValidator->foreignKey($CategoriesEntity)){          
            throw new InvalidForeignKeyException();
        }
     
        if(!$CategoriesValidator->dupName($CategoriesEntity, $id)){ 
            throw new DuplicateException();
        }
     
        if($id !== null && !$CategoriesValidator->validateTree($CategoriesEntity, $id)){          
            throw new InvalidDataException();
        }
        
        $CategoriesEntity->setDefault();       
     
        return $CategoriesEntity->toArray();
    }
}
