<?php

namespace app\Validations;

use app\Models\Tags;
use app\Models\Words;
use libs\Customs\Regular;

class WordsTagsValidation
{
    public $requiredKeys;

    public function __construct()
    {
        $this->requiredKeys = [
            'ts_id', 'ws_id'
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

        // 外鍵 ws_id
        if (!$this->validateWordsForeignKey($data['ws_id'])) {
            return false;
        }

        // 外鍵 ts_id
        if (!$this->validateTagsForeignKey($data['ts_id'])) {
            return false;
        }

        return true;
    }

    //  外鍵檢查 INTEGER
    public function validateWordsForeignKey($ws_id)
    {

        // 1. 先把布林過濾掉
        if (is_bool($ws_id)) {
            return false;
        }

        // 2. 若是null及空值則直接通過 本關聯表不能存空值
        //    用 === 過濾掉 0 1 避免判斷錯誤
        if ($ws_id === null || $ws_id === '') {
            return false;
        }

        // 3. 若ws_id有值 則檢查其資料格式 不符合就直接過濾掉
        if (!Regular::PositiveInt($ws_id)) {
            return false;
        }

        // 4. 最後檢查是否已存在於該資料表中
        $WordsModel = new Words();
        if ($WordsModel->find($ws_id) == null) {
            return false;
        }

        return true;
    }

    //  外鍵檢查 INTEGER
    public function validateTagsForeignKey($ts_id)
    {

        // 1. 先把布林過濾掉
        if (is_bool($ts_id)) {
            return false;
        }

        // 2. null及空值則直接過濾掉 本關聯表不能存空值
        //    用 === 過濾掉 0 1 避免判斷錯誤
        if ($ts_id === null || $ts_id === '') {
            return false;
        }

        // 3. 若ts_id有值 則檢查其資料格式 不符合就直接過濾掉
        if (!Regular::PositiveInt($ts_id)) {
            return false;
        }

        // 4. 最後檢查是否已存在於該資料表中
        $TagsModel = new Tags();
        if ($TagsModel->find($ts_id) == null) {
            return false;
        }

        return true;
    }
}
