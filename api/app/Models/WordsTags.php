<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

class WordsTags
{
    /* 查詢單一資料 words_tags  id = ? */
    public function find($id)
    {
        $result = R::findOne('words_tags', ' id = ? ', array($id));

        return $result;
    }
    /* 查詢所有資料 words_tags */
    public function findAll()
    {

        $result = R::findAll('words_tags');

        return $result;
    }

    /* 新增單一資料 words_tags */
    public function add($data)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {
            $words_tags = R::dispense('words_tags');            
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
    /* 修改edit資料 words_tags */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $words_tags = R::load('words_tags', $id);
            $words_tags->ts_id = is_numeric($data['ts_id']) ? (int)$data['ts_id'] : null;
            $words_tags->ws_id = is_numeric($data['ws_id']) ? (int)$data['ws_id'] : null;             
            $words_tags->updated_at = Time::getNow();
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
}
