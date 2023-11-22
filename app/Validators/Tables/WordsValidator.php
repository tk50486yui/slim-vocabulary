<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Validators\ValidatorHelper as VH;
use app\Entities\WordsEntity;
use app\Models\Words;

class WordsValidator
{   
    public function foreignKey(WordsEntity $entity)
    {
        if(VH::acceptNullEmpty($entity->cate_id)){
            return true;
        }
        if (!VFK::cateID($entity->cate_id)) {
            return false;
        }

        return true;
    }    
    
    public function dupName(WordsEntity $entity, $id)
    {      
        $WordsModel = new Words();
        $rowDup = $WordsModel->findByName($entity->ws_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $WordsModel->find($id);
        if ($row['ws_name'] == $rowDup['ws_name']) {
            return true;
        }

        return false;
    }
}
