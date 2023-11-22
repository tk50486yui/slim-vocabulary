<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Entities\WordsGroupsDetailsEntity;
use app\Models\WordsGroupsDetails;

class WordsGroupsDetailsValidator
{
    public function foreignKey(WordsGroupsDetailsEntity $entity)
    {
                
        if (!VFK::wsID($entity->ws_id)) {
            return false;
        }
        if (!VFK::wgID($entity->wg_id)) {
            return false;
        }  

        return true;
    }

    public function dupKey(WordsGroupsDetailsEntity $entity)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $row = $WordsGroupsDetailsModel
                ->findByAssociatedIDs($entity->ws_id, $entity->wg_id);        
        if($row != null){
            return false;
        }

        return true;
    }
}
