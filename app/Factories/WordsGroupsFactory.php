<?php

namespace app\Factories;

use app\Entities\WordsGroupsEntity;
use app\Validators\Tables\WordsGroupsValidator;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\DuplicateException;

class WordsGroupsFactory
{
    public function createFactory($data, $id)
    {
        $WordsGroupsEntity = new WordsGroupsEntity();        
        $WordsGroupsValidator= new WordsGroupsValidator();

        $WordsGroupsEntity->populate($data);
    
        if (!$WordsGroupsEntity->validate()) {
            throw new InvalidDataException();
        }
    
        if(!$WordsGroupsValidator->dupName($WordsGroupsEntity, $id)){
            throw new DuplicateException();
        }     
     
        return $WordsGroupsEntity->toArray();
    }
}
