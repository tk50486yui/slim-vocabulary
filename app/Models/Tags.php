<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class Tags
{
    public function find($id)
    {
        $result = R::findOne('tags', ' id = ? ', array($id));
        return $result;
    }

    public function findAll()
    {       
        $query = "SELECT * FROM tags ORDER BY ts_order ASC";
        $result = R::getAll($query);

        return $result;
    }
 
    public function findByName($ts_name)
    {
        $result = R::findOne('tags', ' ts_name = ? ', array($ts_name));
        return $result;
    }

    public function findCheckParent($id, $ts_parent_id){
      

        $query = "SELECT * FROM tags WHERE ts_parent_id = ? AND id = ?";
        $result = R::getAll($query, array($id, $ts_parent_id));

        return $result;
    }

    public function findMaxOrderByParent($ts_parent_id)
    {
        $query = "SELECT 
                    MAX(ts_order) as max_ts_order,
                    COUNT(id) as sibling_count
                FROM 
                    tags           
                WHERE 
                    ts_parent_id = ?";

        $result = R::getRow($query, array($ts_parent_id));
      
        return $result;
    }

    public function findOrderInFirstLevel()
    {
        $query = "SELECT 
                    MAX(ts_order) as max_ts_order
                FROM 
                    tags           
                WHERE 
                    ts_parent_id IS NULL";

        $result = R::getRow($query);
      
        return $result;
    }
    
    public function add($data)
    {
        $tags = R::dispense('tags');
        $tags->ts_name = $data['ts_name'];
        $tags->ts_storage = $data['ts_storage'];
        $tags->ts_parent_id = $data['ts_parent_id'];
        $tags->ts_level = $data['ts_level'];
        $tags->ts_order =$data['ts_order'];
        $tags->ts_description = $data['ts_description'];
        R::store($tags);
    }
 
    public function edit($data, $id)
    {
        $tags = R::load('tags', $id);
        $tags->ts_name = $data['ts_name'];
        $tags->ts_parent_id = $data['ts_parent_id'];
        $tags->ts_level = $data['ts_level'];
        $tags->ts_storage = $data['ts_storage'];
        $tags->ts_description = $data['ts_description'];
        $tags->updated_at = Time::getNow();
        R::store($tags);
    }   

    public function editOrder($ts_order, $id)
    {
        $tags = R::load('tags', $id);  
        $tags->ts_order = $ts_order;
        $tags->updated_at = Time::getNow();
        R::store($tags);
    }
  
    public function delete($id)
    {
        $tags = R::load('tags', $id);
        R::trash($tags);        
    }

    public function findRecent()
    {       
        $query = "SELECT * FROM tags ORDER BY created_at DESC, updated_at DESC";
        $result = R::getAll($query);

        return $result;
    }

    function buildTagsTree($tags, $parent_id = null, $parents = []) {

        $tree = array();
    
        foreach ($tags as $tag) {
            if ($tag['ts_parent_id'] == $parent_id) {
                $node = array(
                    'id' => $tag['id'],
                    'ts_name' => $tag['ts_name'],
                    'ts_parent_id' => $tag['ts_parent_id'],
                    'ts_level' => $tag['ts_level'],
                    'ts_order' => $tag['ts_order'],
                    'parents' => $parents,
                    'children' => $this->buildTagsTree($tags, $tag['id'], array_merge($parents, [$tag['id']]))
                );              
    
                $tree[] = $node;
            }
        }
    
        return $tree;
    }
    
}
