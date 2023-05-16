<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Validators\ValidatorHelper as VH;
use app\Entities\TagsEntity;
use app\Models\Tags;

class TagsValidator
{
    
    public function foreignKey(TagsEntity $entity)
    {
        if(VH::acceptNullEmpty($entity->ts_parent_id)){
            return true;
        }
        if (!VFK::tsID($entity->ts_parent_id)) {
            return false;
        }

        return true;
    }

    public function dupName(TagsEntity $entity, $id)
    {
        $TagsModel = new Tags();
        $rowDup = $TagsModel->findByName($entity->ts_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $TagsModel->find($id);
        if ($row['ts_name'] == $rowDup['ts_name']) {
            return true;
        }

        return false;
    }
  
}