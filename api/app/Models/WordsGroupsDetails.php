<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

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
        /* Transaction */
        R::begin();
        try {
            $words_groups_details = R::dispense('words_groups_details');        
            $words_groups_details->ws_id = is_numeric($data['ws_id']) ? (int)$data['ws_id'] : null;    
            $words_groups_details->wg_id = is_numeric($data['wg_id']) ? (int)$data['wg_id'] : null;
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
    /* 修改edit資料 words_groups_details */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $words_groups_details = R::load('words_groups_details', $id);
            $words_groups_details->ws_id = is_numeric($data['ws_id']) ? (int)$data['ws_id'] : null;    
            $words_groups_details->wg_id = is_numeric($data['wg_id']) ? (int)$data['wg_id'] : null;
            $words_groups_details->wgd_content = $data['wgd_content'];             
            $words_groups_details->updated_at = Time::getNow();
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
}
