<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

class WordsTags
{
    const TABLE_NAME = 'words_tags';

    /* 查詢單一資料 words_tags  id = ? */
    public function find($id)
    {
        $result = R::findOne(SELF::TABLE_NAME, ' id = ? ', array($id));

        return $result;
    }

    /* 查詢所有資料 words_tags */
    public function findAll()
    {

        $result = R::findAll(SELF::TABLE_NAME);

        return $result;
    }

    /* 新增單一資料 words_tags */
    public function add($data)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {
            $words_tags = R::dispense(SELF::TABLE_NAME);
            $words_tags->ts_id = is_numeric($data['ts_id']) ? (int)$data['ts_id'] : null;
            $words_tags->ws_id = is_numeric($data['ws_id']) ? (int)$data['ws_id'] : null;
            R::store($words_tags);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* 刪除關聯資料 words_tags */
    public function delete($id)
    {
        $result = false;
        /* Transaction */
        R::begin();

        try {
            $words_tags = R::load(SELF::TABLE_NAME, $id);
            R::trash($words_tags);
            R::commit();
            R::close();
            $result = true;

        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }
}
