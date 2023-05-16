<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class Words
{   
    public function find($id)
    {
        $query = "SELECT 
                    ws.*, cate.cate_name as cate_name
                FROM 
                    words ws
                LEFT JOIN 
                    categories cate ON ws.cate_id =  cate.id
                WHERE 
                    ws.id = ?";

        $result = R::getRow($query, array($id));    
       
        return $result;
    }
  
    public function findAll()
    {
        $query = "SELECT 
                    ws.*, cate.cate_name as cate_name
                FROM 
                    words ws
                LEFT JOIN 
                    categories cate ON ws.cate_id =  cate.id";

        $result = R::getAll($query);
        
        return $result;
    }
 
    public function findByName($ws_name)
    {
        $result = R::findOne('words', 'ws_name = ? ', array($ws_name));
        return $result;
    }
 
    public function add($data)
    {
        $words = R::dispense('words');
        $words->ws_name = $data['ws_name'];
        $words->ws_definition = $data['ws_definition'];
        $words->ws_pronunciation = $data['ws_pronunciation'];
        $words->ws_slogan = $data['ws_slogan'];
        $words->ws_description = $data['ws_description'];
        $words->ws_is_important = $data['ws_is_important'];
        $words->ws_is_common = $data['ws_is_common'];
        $words->ws_forget_count = $data['ws_forget_count'];
        $words->ws_display_order =$data['ws_display_order'];
        $words->cate_id = $data['cate_id'];
        R::store($words);
    }
  
    public function edit($data, $id)
    {
        $words = R::load('words', $id);
        $words->ws_name = $data['ws_name'];
        $words->ws_definition = $data['ws_definition'];
        $words->ws_pronunciation = $data['ws_pronunciation'];
        $words->ws_slogan = $data['ws_slogan'];
        $words->ws_description = $data['ws_description'];
        $words->ws_is_important = $data['ws_is_important'];
        $words->ws_is_common = $data['ws_is_common'];
        $words->ws_forget_count = $data['ws_forget_count'];
        $words->ws_display_order =$data['ws_display_order'];
        $words->cate_id = $data['cate_id'];
        $words->updated_at = Time::getNow();
        R::store($words);
    }
   
    public function delete($id)
    {
        $words = R::load('words', $id);
        R::trash($words);       
    }
   
}
