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
                    ws.*, cate.cate_name as cate_name,
                    json_build_object('values',                   
                        (
                            SELECT 
                                json_agg(json_build_object('ts_id', ts.id, 'ts_name', ts.ts_name))
                            FROM 
                                words_tags wt
                            LEFT JOIN 
                                tags ts ON wt.ts_id = ts.id
                            WHERE 
                                wt.ws_id = ws.id
                        
                        )
                    ) AS words_tags                
                FROM 
                    words ws
                LEFT JOIN 
                    categories cate ON ws.cate_id =  cate.id                     
                ORDER BY 
                    ws.id DESC";

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
        $words->ws_order =$data['ws_order'];
        $words->cate_id = $data['cate_id'];
        $id = R::store($words);
        return $id;
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
        $words->ws_order =$data['ws_order'];
        $words->cate_id = $data['cate_id'];
        $words->updated_at = Time::getNow();
        R::store($words);
    }

    public function editCommon($data, $id)
    {        
        $words = R::load('words', $id);  
        $words->ws_is_common = $data['ws_is_common'];      
        $words->updated_at = Time::getNow();      
        R::store($words);   
    }

    public function editImportant($data, $id)
    {
        $words = R::load('words', $id);
        $words->ws_is_important = $data['ws_is_important'];
        $words->updated_at = Time::getNow();
        R::store($words);
    }
   
    public function delete($id)
    {
        $words = R::load('words', $id);
        R::trash($words);       
    }
   
}
