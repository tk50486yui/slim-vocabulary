<?php

namespace app\Validators\Tables;

use app\Models\Categories;
use libs\Regular;

class ArticlesValidator
{
    public $requiredKeys;

    public function __construct()
    {
        $this->requiredKeys = [
            'arti_title', 'arti_content', 'arti_order', 'cate_id'
        ];
    }
    /**   
     * 驗證傳進來的資料名稱是否與資料表的一致 並檢查外鍵及NOT NULL欄位  
     * 本頁面只檢查不改動任何資料 若有預設值統一在Model進行設定
    **/ 
    public function validate($data)
    {  
        // 檢查key都有存在
        $missingKeys = array_diff($this->requiredKeys, array_keys($data));
        if (!empty($missingKeys)) {
            return false;
        }

        // NOT NULL TEXT欄位
        if (is_bool($data['arti_content']) || empty($data['arti_content'])) {
            return false;
        }     
        
        // 外鍵 cate_id
        if(!$this->validateCategoriesForeignKey($data['cate_id'])){
            return false;
        }

        return true;        
    }

    //  外鍵檢查 INTEGER
    public function validateCategoriesForeignKey($cate_id){

        // 1. 先把布林過濾掉
        if(is_bool($cate_id)){
            return false;
        }

        // 2. 若是null及空值則直接通過 因為本表的cate_id可以存放null  進入Model時再設定預設值
        // 用 === 過濾掉 0 1 避免判斷錯誤
        if($cate_id === null || $cate_id === ''){
            return true;
        }
        
        // 3. 若cate_id有值 則檢查其資料格式 不符合就直接過濾掉
        if(!Regular::PositiveInt($cate_id)){
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
