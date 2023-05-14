<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

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

    /* 查詢資料 words_tags_details ws_id 及 wg_id */
    public function findByAssociatedIDs($data)
    {
        // binding 的長度必須一致
        $keyword = array(
            "ws_id" => $data['ws_id'],
            "wg_id" => $data['wg_id']
        );
        $result = R::findOne('words_groups_details', 'ws_id = :ws_id AND wg_id = :wg_id', $keyword);        
        return $result;
    }

    /* 新增單一資料 words_groups_details */
    public function add($data)
    {
        // 使用自訂義 xdispense
        $words_groups_details = R::xdispense('words_groups_details');
        $words_groups_details->ws_id = (int)$data['ws_id'];
        $words_groups_details->wg_id = (int)$data['wg_id'];
        $words_groups_details->wgd_content = $data['wgd_content'];
        R::store($words_groups_details);
    }

    /* 修改 edit 資料 tags */
    public function edit($data, $id)
    {
        $words_groups_details = R::load('words_groups_details', $id);  
        $words_groups_details->wgd_content = $data['wgd_content'];
        $words_groups_details->updated_at = Time::getNow();
        R::store($words_groups_details);
    }

    /* 刪除關聯資料 words_groups_details */
    public function delete($id)
    {
        $words_groups_details = R::load('words_groups_details', $id);
        R::trash($words_groups_details);
    }
}
