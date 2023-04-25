<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

class WordsGroups
{
    const TABLE_NAME = 'words_groups';

    /* 查詢單一資料 words_groups  id = ? */
    public function find($id)
    {
        $result = R::findOne(SELF::TABLE_NAME, ' id = ? ', array($id));

        return $result;
    }

    /* 查詢所有資料 words_groups */
    public function findAll()
    {

        $result = R::findAll(SELF::TABLE_NAME);

        return $result;
    }

    /* 新增單一資料 words_groups */
    public function add($data)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {
            $words_groups = R::dispense(SELF::TABLE_NAME);
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

    /* 修改 edit 資料 words_groups */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $words_groups = R::load(SELF::TABLE_NAME, $id);
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

    /* 刪除關聯資料 words_groups */
    public function delete($id)
    {
        $result = false;
        /* Transaction */
        R::begin();

        try {
            $words_groups = R::load(SELF::TABLE_NAME, $id);
            R::trash($words_groups);
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
