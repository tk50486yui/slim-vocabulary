<?php

namespace app\Factories;

use app\Entities\WordsEntity;
use app\Validators\Tables\WordsValidator;
use app\Validators\ValidatorHelper as VH;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;

class WordsFactory
{
    public function createFactory($data, $id)
    {
        $WordsEntity = new WordsEntity();        
        $WordsValidator= new WordsValidator();

        $WordsEntity->populate($data);
        
        if (!$WordsEntity->validate()) {
            throw new InvalidDataException();
        }
        if(!$WordsValidator->foreignKey($WordsEntity)){          
            throw new InvalidForeignKeyException();
        }
        if(!$WordsValidator->dupName($WordsEntity, $id)){          
            throw new DuplicateException();
        }
        
        $WordsEntity->setDefault();
     
        return $WordsEntity->toArray();
    }

    // 不驗證 只注入資料及null判斷
    public function assembleFactory($data)
    {
        $WordsEntity = new WordsEntity();      

        $WordsEntity->populate($data); 
        
        $WordsEntity->setDefault();
     
        return $WordsEntity->toArray();
    }
}
