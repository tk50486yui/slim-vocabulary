<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

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
        $tags->ts_storage = $data['ts_storage'];
        $tags->ts_parent_id = $data['ts_parent_id'];
        $tags->ts_level = $data['ts_level'];
        $tags->ts_sort_order =$data['ts_sort_order'];
        $tags->ts_description = $data['ts_description'];
        R::store($tags);
    }

    /* 修改 edit 資料 tags */
    public function edit($data, $id)
    {
        $tags = R::load('tags', $id);
        $tags->ts_name = $data['ts_name'];
        $tags->ts_storage = $data['ts_storage'];
        $tags->ts_parent_id = $data['ts_parent_id'];
        $tags->ts_level = $data['ts_level'];
        $tags->ts_sort_order =$data['ts_sort_order'];
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
