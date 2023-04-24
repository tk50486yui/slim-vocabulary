<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

class WordsGroups
{
    /* 查詢單一資料 words_groups  id = ? */
    public function find($id)
    {
        $result = R::findOne('words_groups', ' id = ? ', array($id));

        return $result;
    }
    /* 查詢所有資料 words_groups */
    public function findAll()
    {

        $result = R::findAll('words_groups');

        return $result;
    }

    /* 新增單一資料 words_groups */
    public function add($data)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {
            $words_groups = R::dispense('words_groups');
            $words_groups->wg_name = $data['wg_name'];        
            R::store($words_groups);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }
    /* 修改edit資料 words_groups */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $words_groups = R::load('words_groups', $id);
            $words_groups->wg_name = $data['wg_name'];             
            $words_groups->updated_at = Time::getNow();
            R::store($words_groups);
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
