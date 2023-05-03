<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use Exception;

class WordsGroupsDetails
{    

    /* 查詢單一資料 words_groups_details  id = ? */
    public function find($id)
    {
        $result = R::findOne('words_groups_details', ' id = ? ', array($id));

        return $result;
    }

    /* 查詢所有資料 words_groups_details */
    public function findAll()
    {

        $result = R::findAll('words_groups_details');

        return $result;
    }

    /* 新增單一資料 words_groups_details */
    public function add($data)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            // 使用自訂義 xdispense
            $words_groups_details = R::xdispense('words_groups_details');        
            $words_groups_details->ws_id = (int)$data['ws_id'];
            $words_groups_details->wg_id = (int)$data['wg_id'];
            $words_groups_details->wgd_content = $data['wgd_content'];
            R::store($words_groups_details);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* 刪除關聯資料 words_groups_details */
    public function delete($id)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            $words_groups_details = R::load('words_groups_details', $id);
            R::trash($words_groups_details);
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
