<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

class Categories
{
    /* 查詢單一資料 categories  id = ? */
    public function find($id)
    {
        $result = R::findOne('categories', ' id = ? ', array($id));
        
        return $result;
    }
    /* 查詢所有資料 categories */
    public function findAll()
    {

        $result = R::findAll('categories');

        return $result;
    }
    /* 以 cate_name 查詢 categories 表 */
    public function findByName($cate_name)
    {
        $result = false;
        $row = R::findOne('categories', ' cate_name = ? ', array($cate_name));
        if ($row == null) {           
            $result = true;
        }
        return $result;
    }
    /* 新增單一資料 categories */
    public function add($data)
    {
        $result = false;       
        /* Transaction */
        R::begin();
        try {
            $categories = R::dispense('categories');
            $categories->cate_name = $data['cate_name'];            
            $categories->cate_parent_id = is_numeric($data['cate_parent_id']) ? (int)$data['cate_parent_id'] : null;
            $categories->cate_level = is_numeric($data['cate_level']) ? (int)$data['cate_level'] : 1;
            $categories->cate_sort_order = is_numeric($data['cate_sort_order']) ? (int)$data['cate_sort_order'] : 1;
            R::store($categories);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }
    /* 修改edit資料 words */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $categories = R::load('categories', $id);
            $categories->cate_name = $data['cate_name'];            
            $categories->cate_parent_id = is_numeric($data['cate_parent_id']) ? (int)$data['cate_parent_id'] : null;
            $categories->cate_level = is_numeric($data['cate_level']) ? (int)$data['cate_level'] : 1;
            $categories->cate_sort_order = is_numeric($data['cate_sort_order']) ? (int)$data['cate_sort_order'] : 1;
            $categories->updated_at = Time::getNow();
            R::store($categories);
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
