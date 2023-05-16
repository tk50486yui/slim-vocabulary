<?php

namespace app\Factories;

use app\Entities\WordsGroupsDetailsEntity;
use app\Validators\Tables\WordsGroupsDetailsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class WordsGroupsDetailsFactory
{
    public function createFactory($data, $id)
    {
        $WordsGroupsDetailsEntity = new WordsGroupsDetailsEntity();        
        $WordsGroupsDetailsValidator= new WordsGroupsDetailsValidator();

        $WordsGroupsDetailsEntity->populate($data);
       
        if (!$WordsGroupsDetailsEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$WordsGroupsDetailsValidator->foreignKey($WordsGroupsDetailsEntity)){          
            throw new InvalidForeignKeyException();
        }
        if($id === null && !$WordsGroupsDetailsValidator->dupKey($WordsGroupsDetailsEntity)){          
            throw new DuplicateException();
        } 
     
        $WordsGroupsDetailsEntity->setDefault();
        
        return $WordsGroupsDetailsEntity->toArray();
    }
}
