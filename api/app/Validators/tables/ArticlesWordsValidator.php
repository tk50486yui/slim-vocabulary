<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Entities\ArticlesWordsEntity;
use app\Models\ArticlesWords;

class ArticlesWordsValidator
{
    public function foreignKey(ArticlesWordsEntity $entity)
    {
                
        if (!VFK::artiID($entity->arti_id)) {
            return false;
        }
        if (!VFK::wsID($entity->ws_id)) {
            return false;
        }  

        return true;
    }

    public function dupKey(ArticlesWordsEntity $entity)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $row = $ArticlesWordsModel
                ->findByAssociatedIDs($entity->arti_id, $entity->ws_id);        
        if($row != null){
            return false;
        }

        return true;
    }
}
