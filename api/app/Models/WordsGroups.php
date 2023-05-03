<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Customs\Time;
use Exception;

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

    /* 以 wg_name 查詢 words_group 表 */
    public function findByName($wg_name)
    {
        
        $result = R::findOne('wg_name', ' wg_name = ? ', array($wg_name));        
        
        return $result;
    }

    /* 新增單一資料 words_groups */
    public function add($data)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            // 使用自訂義 xdispense
            $words_groups = R::xdispense('words_groups');
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
        // Transaction
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

    /* 刪除關聯資料 words_groups */
    public function delete($id)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            $words_groups = R::load('words_groups', $id);
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
