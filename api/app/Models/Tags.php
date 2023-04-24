<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

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
        $result = false;
        $row = R::findOne('tags', ' ts_name = ? ', array($ts_name));
        if ($row == null) {           
            $result = true;
        }
        return $result;
    }
    /* 新增單一資料 tags */
    public function add($data)
    {
        $result = false;       
        /* Transaction */
        R::begin();
        try {
            $tags = R::dispense('tags');
            $tags->ts_name = $data['ts_name'];  
            $tags->ts_storage = is_bool($data['ts_storage']) ? (bool)$data['ts_storage'] : true;    
            $tags->ts_parent_id = is_numeric($data['ts_parent_id']) ? (int)$data['ts_parent_id'] : null;
            $tags->ts_level = is_numeric($data['ts_level']) ? (int)$data['ts_level'] : 1;
            $tags->ts_sort_order = is_numeric($data['ts_sort_order']) ? (int)$data['ts_sort_order'] : 1;
            $tags->ts_description = $data['ts_description'];
            R::store($tags);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }
    /* 修改edit資料 tags */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $tags = R::load('tags', $id);
            $tags->ts_name = $data['ts_name'];  
            $tags->ts_storage = is_bool($data['ts_storage']) ? (bool)$data['ts_storage'] : true;    
            $tags->ts_parent_id = is_numeric($data['ts_parent_id']) ? (int)$data['ts_parent_id'] : null;
            $tags->ts_level = is_numeric($data['ts_level']) ? (int)$data['ts_level'] : 1;
            $tags->ts_sort_order = is_numeric($data['ts_sort_order']) ? (int)$data['ts_sort_order'] : 1;
            $tags->ts_description = $data['ts_description'];
            $tags->updated_at = Time::getNow();
            R::store($tags);
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
