<?php

namespace app\Validators\Tables;

use app\Entities\WordsGroupsEntity;
use app\Models\WordsGroups;

class WordsGroupsValidator
{   
    public function dupName(WordsGroupsEntity $entity, $id)
    {      
        $WordsGroupsModel = new WordsGroups();        
        $rowDup = $WordsGroupsModel->findByName($entity->wg_name);
        if ($rowDup == null) {           
            return true;
        }     
        if ($id === null) {
            return false;
        }
        $row = $WordsGroupsModel->find($id);
        if ($row['wg_name'] == $rowDup['wg_name']) {
            return true;
        }

        return false;
    }
}
