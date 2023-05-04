<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Customs\Time;

class Tags
{
    /* 查詢單一資料 tags  id = ? */
    public function find($id)
    {
        $result = R::findOne('tags', ' id = ? ', array($id));
        return $result;
    }

    /* 查詢所有資料 tags */
    public function findAll()
    {
        $result = R::findAll('tags');
        return $result;
    }

    /* 以 ts_name 查詢 tags 表 */
    public function findByName($ts_name)
    {
        $result = R::findOne('tags', ' ts_name = ? ', array($ts_name));
        return $result;
    }

    /* 新增單一資料 tags */
    public function add($data)
    {
        $tags = R::dispense('tags');
        $tags->ts_name = $data['ts_name'];
        $tags->ts_storage = is_bool($data['ts_storage']) ? (bool)$data['ts_storage'] : true;
        $tags->ts_parent_id = is_numeric($data['ts_parent_id']) ? (int)$data['ts_parent_id'] : null;
        $tags->ts_level = is_numeric($data['ts_level']) ? (int)$data['ts_level'] : 1;
        $tags->ts_sort_order = is_numeric($data['ts_sort_order']) ? (int)$data['ts_sort_order'] : 1;
        $tags->ts_description = $data['ts_description'];
        R::store($tags);
    }

    /* 修改 edit 資料 tags */
    public function edit($data, $id)
    {
        $tags = R::load('tags', $id);
        $tags->ts_name = $data['ts_name'];
        $tags->ts_storage = is_bool($data['ts_storage']) ? (bool)$data['ts_storage'] : true;
        $tags->ts_parent_id = is_numeric($data['ts_parent_id']) ? (int)$data['ts_parent_id'] : null;
        $tags->ts_level = is_numeric($data['ts_level']) ? (int)$data['ts_level'] : 1;
        $tags->ts_sort_order = is_numeric($data['ts_sort_order']) ? (int)$data['ts_sort_order'] : 1;
        $tags->ts_description = $data['ts_description'];
        $tags->updated_at = Time::getNow();
        R::store($tags);
    }

    /* 刪除關聯資料 tags */
    public function delete($id)
    {
        $tags = R::load('tags', $id);
        R::trash($tags);        
    }
}
