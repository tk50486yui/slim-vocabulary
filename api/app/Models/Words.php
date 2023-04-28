<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Customs\Time;
use Exception;

class Words
{
    const TABLE_NAME = 'words';

    /* 查詢單一資料 words id = ? */
    public function find($id)
    {
        $result = R::findOne(SELF::TABLE_NAME, ' id = ? ', array($id));

        return $result;
    }

    /* 查詢所有資料 words */
    public function findAll()
    {

        $result = R::findAll(SELF::TABLE_NAME);

        return $result;
    }

    /* 以 ws_name 查詢 words 表 */
    public function findByName($ws_name)
    {
        $result = false;
        $row = R::findOne(SELF::TABLE_NAME, ' ws_name = ? ', array($ws_name));
        if ($row == null) { 
            $result = true;
        }
        return $result;
    }

    /* 新增單一資料 words */
    public function add($data)
    {
        $result = false;       
        /* Transaction */
        R::begin();
        try {
            $words = R::dispense(SELF::TABLE_NAME);
            $words->ws_name = $data['ws_name'];
            $words->ws_definition = $data['ws_definition'];
            $words->ws_pronunciation = $data['ws_pronunciation'];
            $words->ws_slogan = $data['ws_slogan'];
            $words->ws_description = $data['ws_description'];
            $words->ws_difficulty = $data['ws_difficulty'];
            $words->ws_type = $data['ws_type'];
            $words->ws_part_of_speech = $data['ws_part_of_speech'];
            $words->ws_is_important = is_bool($data['ws_is_important']) ? (bool)$data['ws_is_important'] : false;
            $words->ws_is_common = is_bool($data['ws_is_common']) ? (bool)$data['ws_is_common'] : false;
            $words->ws_forget_count = is_numeric($data['ws_forget_count']) ? (int)$data['ws_forget_count'] : 0;
            $words->ws_display_order = is_numeric($data['ws_display_order']) ? (int)$data['ws_display_order'] : 1;
            $words->cate_id = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;
            R::store($words);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* 修改 edit 資料 words */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $words = R::load(SELF::TABLE_NAME, $id);
            $words->ws_name = $data['ws_name'];
            $words->ws_definition = $data['ws_definition'];
            $words->ws_pronunciation = $data['ws_pronunciation'];
            $words->ws_slogan = $data['ws_slogan'];
            $words->ws_description = $data['ws_description'];
            $words->ws_difficulty = $data['ws_difficulty'];
            $words->ws_type = $data['ws_type'];
            $words->ws_part_of_speech = $data['ws_part_of_speech'];
            $words->ws_is_important = is_bool($data['ws_is_important']) ? (bool)$data['ws_is_important'] : false;
            $words->ws_is_common = is_bool($data['ws_is_common']) ? (bool)$data['ws_is_common'] : false;
            $words->ws_forget_count = is_numeric($data['ws_forget_count']) ? (int)$data['ws_forget_count'] : 0;
            $words->ws_display_order = is_numeric($data['ws_display_order']) ? (int)$data['ws_display_order'] : 1;
            $words->cate_id = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;
            $words->updated_at = Time::getNow();
            R::store($words);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();            
            $result = false;
        }

        return $result;
    }

    /* 刪除資料 words */
    public function delete($id)
    {
        $result = false;
        /* Transaction */
        R::begin();

        try {
            $words = R::load(SELF::TABLE_NAME, $id);
            R::trash($words);
            R::commit();
            R::close();
            $result = true;

        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* JOIN 查詢 words LEFT JOIN categories 全部資料 */
    public function findCategoriesAll()
    {
        $query = "SELECT 
                    ws.*, cate.cate_name as cate_name
                FROM 
                    words ws
                LEFT JOIN categories cate ON ws.cate_id =  cate.id";

        $result = R::getAll($query);

        return $result;
    }
    
}
