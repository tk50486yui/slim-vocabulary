<?php

namespace app\Validators\Tables;

use app\Entities\WordsEntity;
use app\Models\Categories;
use app\Models\Words;

class WordsValidator
{
    //  外鍵檢查 INTEGER
    public function validateForeignKey(WordsEntity $entity)
    {
        if (!$this->cateID($entity->cate_id)) {
            return false;
        }

        return true;
    }

    
    public function cateID($cate_id)
    {
        $CategoriesModel = new Categories();
        if ($CategoriesModel->find($cate_id) == null) {
            return false;
        }

        return true;
    }

    // 　檢查有沒有重複的單詞  
    public function dupName($ws_name)
    {
        $WordsModel = new Words();

        if ($WordsModel->findByName($ws_name) != null) {
            return false;
        }

        return true;
    }
}
