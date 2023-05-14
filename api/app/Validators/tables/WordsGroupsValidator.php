<?php

namespace app\Validators\tables;

class WordsGroupsValidator
{
    public $requiredKeys;

    public function __construct()
    {
        $this->requiredKeys = [
            'wg_name'
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
        if (is_bool($data['wg_name']) || empty($data['wg_name'])) {
            return false;
        }  

        return true;        
    }
  
}
