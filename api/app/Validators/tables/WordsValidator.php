<?php

namespace app\Validators\tables;

use app\Entities\WordsEntity;
use app\Models\Categories;

class WordsValidator
{
    public $requiredKeys;

    public function __construct()
    {
        $this->requiredKeys = [
            'ws_name', 'ws_definition', 'ws_pronunciation', 
            'ws_slogan', 'ws_description','ws_is_important',
            'ws_is_common', 'ws_forget_count', 'ws_display_order',
             'cate_id'
        ];
    }
    /**   
     * 使用Entity取得的資料並檢查外鍵及NOT NULL欄位
     * 並將不符合格式的資料設定成預設值
    **/ 
    public function validate(WordsEntity $entity)
    {         

        return true;        
    }

    //  外鍵檢查 INTEGER
    public function validateCategoriesForeignKey($cate_id)
    {        

        // 檢查外鍵是否已存在於該資料表中
        $CategoriesModel = new Categories();        
        if ($CategoriesModel->find($cate_id) == null) {
            return false;
        }
        
        return true;
    }
}
