<?php

namespace app\Validations;

use app\Models\Categories;

class WordsValidation
{
    /*  Validation主要是驗證傳進來的資料名稱是否與資料表的一致 並檢查外鍵及 NOT NULL 欄位  */ 
    public function validate($data)
    {  

        $requiredKeys =         
        [
            'ws_name', 'ws_definition', 'ws_pronunciation', 'ws_slogan','ws_description',
            'ws_is_important', 'ws_is_common', 'ws_forget_count', 'ws_display_order', 'cate_id'
        ];

        // 檢查 key 都有存在
        $missingKeys = array_diff($requiredKeys, array_keys($data));
        if (!empty($missingKeys)) {
            return false;
        }

        // 不能為 null
        if (empty($data['ws_name'])) {
            return false;
        }     

        if(!$this->validateCategoriesForeignKey($data['cate_id'])){
            return false;
        }
        
        return true;        
    }

    //  外鍵檢查    
    public function validateCategoriesForeignKey($cate_id){

        // 1. 先把布林過濾掉
        if(is_bool($cate_id)){
            return false;
        }
        // 2. 若是 null 及空值則直接通過 因為本表的 cate_id 可以存放 null
        if($cate_id == null || $cate_id == ''){
            return true;
        }
        // 3. 若 cate_id 有值 則檢查其資料格式 不符合就直接過濾掉
        if(!is_numeric($cate_id) || $cate_id < 1){
            return false;
        }
        // 4. 最後檢查是否已存在於該資料表中
        $CategoriesModel = new Categories();        
        if ($CategoriesModel->find($cate_id) == null) {
            return false;
        }

        return true;
    }
}
