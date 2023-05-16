<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Entities\ArticlesTagsEntity;
use app\Models\ArticlesTags;

class ArticlesTagsValidator
{
    public function foreignKey(ArticlesTagsEntity $entity)
    {
                
        if (!VFK::artiID($entity->arti_id)) {
            return false;
        }
        if (!VFK::tsID($entity->ts_id)) {
            return false;
        }  

        return true;
    }

    public function dupKey(ArticlesTagsEntity $entity)
    {
        $ArticlesTagsModel = new ArticlesTags();
        $row = $ArticlesTagsModel
                ->findByAssociatedIDs($entity->arti_id, $entity->ts_id);        
        if($row != null){
            return false;
        }

        return true;
    }
}
