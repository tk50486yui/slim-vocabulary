<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Entities\WordsTagsEntity;
use app\Models\WordsTags;

class WordsTagsValidator
{
    public function foreignKey(WordsTagsEntity $entity)
    {
                
        if (!VFK::wsID($entity->ws_id)) {
            return false;
        }
        if (!VFK::tsID($entity->ts_id)) {
            return false;
        }  

        return true;
    }

    public function dupKey(WordsTagsEntity $entity)
    {
        $WordsTagsModel = new WordsTags();
        $row = $WordsTagsModel
                ->findByAssociatedIDs($entity->ws_id, $entity->ts_id);        
        if($row != null){
            return false;
        }

        return true;
    }
}
