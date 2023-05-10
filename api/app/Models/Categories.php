<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Customs\Time;

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
        $result = R::findOne('categories', ' cate_name = ? ', array($cate_name));
        return $result;
    }

    /* 新增單一資料 categories */
    public function add($data)
    {
        $categories = R::dispense('categories');
        $categories->cate_name = $data['cate_name'];
        $categories->cate_parent_id = is_numeric($data['cate_parent_id']) ? (int)$data['cate_parent_id'] : null;
        $categories->cate_level = is_numeric($data['cate_level']) ? (int)$data['cate_level'] : 1;
        $categories->cate_sort_order = is_numeric($data['cate_sort_order']) ? (int)$data['cate_sort_order'] : 1;
        R::store($categories);
    }

    /* 修改 edit 資料 categories */
    public function edit($data, $id)
    {
        $categories = R::load('categories', $id);
        $categories->cate_name = $data['cate_name'];
        $categories->cate_parent_id = is_numeric($data['cate_parent_id']) ? (int)$data['cate_parent_id'] : null;
        $categories->cate_level = is_numeric($data['cate_level']) ? (int)$data['cate_level'] : 1;
        $categories->cate_sort_order = is_numeric($data['cate_sort_order']) ? (int)$data['cate_sort_order'] : 1;
        $categories->updated_at = Time::getNow();
        R::store($categories);
    }

    /* 刪除關聯資料 categories */
    public function delete($id)
    {
        $categories = R::load('categories', $id);
        R::trash($categories);
    }

    /* JOIN 查詢 categories id 底下的 words 資料 */
    public function findWordsByID($id)
    {
        $query = "SELECT 
                    cate.*, ws.* 
                FROM 
                    categories cate
                LEFT JOIN 
                    words ws ON cate.id = ws.cate_id 
                WHERE 
                    cate.id = :id";

        $result = R::getAll($query, array(':id' => $id));

        return $result;
    }    

    function buildCategoriesTree($categories, $parent_id = null, $parents = []) {

        $tree = array();
    
        foreach ($categories as $category) {
            if ($category['cate_parent_id'] == $parent_id) {
                $node = array(
                    'id' => $category['id'],
                    'cate_name' => $category['cate_name'],
                    'parents' => $parents,
                    'children' => $this->buildCategoriesTree($categories, $category['id'], array_merge($parents, [$category['id']]))
                );              
    
                $tree[] = $node;
            }
        }
    
        return $tree;
    }
    
}