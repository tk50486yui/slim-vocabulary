<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class Categories
{  
    public function find($id)
    {
        $result = R::findOne('categories', ' id = ? ', array($id));
        return $result;
    }
 
    public function findAll()
    {
        $result = R::findAll('categories');
        return $result;
    }
  
    public function findByName($cate_name)
    {
        $result = R::findOne('categories', ' cate_name = ? ', array($cate_name));
        return $result;
    }
  
    public function add($data)
    {
        $categories = R::dispense('categories');
        $categories->cate_name = $data['cate_name'];
        $categories->cate_parent_id = $data['cate_parent_id'];
        $categories->cate_level = $data['cate_level'];
        $categories->cate_order = $data['cate_order'];
        R::store($categories);
    }

    public function edit($data, $id)
    {
        $categories = R::load('categories', $id);
        $categories->cate_name = $data['cate_name'];
        $categories->cate_parent_id = $data['cate_parent_id'];
        $categories->cate_level = $data['cate_level'];
        $categories->cate_order = $data['cate_order'];
        $categories->updated_at = Time::getNow();
        R::store($categories);
    }
   
    public function delete($id)
    {
        $categories = R::load('categories', $id);
        R::trash($categories);
    }
  
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