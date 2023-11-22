<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Validators\ValidatorHelper as VH;
use app\Entities\ArticlesEntity;

class ArticlesValidator
{
   
    public function foreignKey(ArticlesEntity $entity)
    {
        if (VH::acceptNullEmpty($entity->cate_id)) {
            return true;
        }
        if (!VFK::cateID($entity->cate_id)) {
            return false;
        }

        return true;
    }
   
}
