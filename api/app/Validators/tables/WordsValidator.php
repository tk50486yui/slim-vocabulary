<?php

namespace app\Validators\Tables;

use app\Entities\WordsEntity;
use app\Models\Categories;

class WordsValidator
{   
    /**   
     * 使用Entity取得的資料檢查外鍵   
    **/ 
    public function validateForeignKey(WordsEntity $entity)
    {  
        if(!$this->cateID($entity->cate_id)){
            return false;
        }

        return true;        
    }

    //  外鍵檢查 INTEGER
    public function cateID($cate_id)
    {        

        // 檢查外鍵是否已存在於該資料表中
        $CategoriesModel = new Categories();        
        if ($CategoriesModel->find($cate_id) == null) {
            return false;
        }
        
        return true;
    }
}
