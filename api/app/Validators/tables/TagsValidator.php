<?php

namespace app\Validators\tables;

use app\Models\Tags;
use libs\Regular;

class TagsValidator
{
    public $requiredKeys;

    public function __construct()
    {
        $this->requiredKeys = [
            'ts_name', 'ts_storage', 'ts_parent_id', 'ts_level', 'ts_sort_order',
            'ts_description'
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
        if (is_bool($data['ts_name']) || empty($data['ts_name'])) {
            return false;
        }

        // 外鍵 ts_parent_id
        if (!$this->validateTagsForeignKey($data['ts_parent_id'])) {
            return false;
        }

        return true;      
    }

    //  外鍵檢查 INTEGER
    public function validateTagsForeignKey($ts_parent_id){

        // 1. 先把布林過濾掉
        if(is_bool($ts_parent_id)){
            return false;
        }

        // 2. 若是null及空值則直接通過 因為本表的ts_parent_id可以存放null  進入Model時再設定預設值
        // 用 === 過濾掉 0 1 避免判斷錯誤
        if($ts_parent_id === null || $ts_parent_id === ''){
            return true;
        }

        // 3. 若cate_parent_id有值 則檢查其資料格式 不符合就直接過濾掉
        if(!Regular::PositiveInt($ts_parent_id)){
            return false;
        }
        
        // 4. 最後檢查是否已存在於該資料表中
        $TagsModel = new Tags();        
        if ($TagsModel->find($ts_parent_id) == null) {
            return false;
        }

        return true;
    }
}