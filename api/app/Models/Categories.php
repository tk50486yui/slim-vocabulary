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
 
    public function findAll(){
      

        $query = "SELECT * FROM categories ORDER BY cate_order ASC";
        $result = R::getAll($query);

        return $result;
    }
  
    public function findByName($cate_name)
    {
        $result = R::findOne('categories', ' cate_name = ? ', array($cate_name));
        return $result;
    }

    public function findCheckParent($id, $cate_parent_id){
      

        $query = "SELECT * FROM categories WHERE cate_parent_id = ? AND id = ?";
        $result = R::getAll($query, array($id, $cate_parent_id));

        return $result;
    }

    public function findMaxOrderByParent($cate_parent_id)
    {
        $query = "SELECT 
                    MAX(cate_order) as max_cate_order,
                    COUNT(id) as sibling_count
                FROM 
                    categories           
                WHERE 
                    cate_parent_id = ?";

        $result = R::getRow($query, array($cate_parent_id));
      
        return $result;
    }

    public function findOrderInFirstLevel()
    {
        $query = "SELECT 
                    MAX(cate_order) as max_cate_order
                FROM 
                    categories
                WHERE 
                    cate_parent_id IS NULL";

        $result = R::getRow($query);
      
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
        $categories->updated_at = Time::getNow();
        R::store($categories);
    }   

    public function editOrder($cate_order, $id)
    {
        $categories = R::load('categories', $id);  
        $categories->cate_order = $cate_order;
        $categories->updated_at = Time::getNow();
        R::store($categories);
    }
   
    public function delete($id)
    {
        $categories = R::load('categories', $id);
        R::trash($categories);
    }

    public function findRecent()
    {       
        $query = "SELECT * FROM categories ORDER BY created_at DESC, updated_at DESC";
        $result = R::getAll($query);

        return $result;
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
                    'cate_parent_id' => $category['cate_parent_id'],
                    'cate_level' => $category['cate_level'],
                    'cate_order' => $category['cate_order'],
                    'parents' => $parents,
                    'children' => $this->buildCategoriesTree($categories, $category['id'], array_merge($parents, [$category['id']]))
                );              
    
                $tree[] = $node;
            }
        }
    
        return $tree;
    }
    
}