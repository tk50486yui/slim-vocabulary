<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class Articles
{
  
    public function find($id)
    {
        $query = "SELECT 
                    arti.*, cate.cate_name as cate_name
                FROM 
                    articles arti
                LEFT JOIN 
                    categories cate ON arti.cate_id = cate.id
                WHERE 
                    arti.id = ?";

        $result = R::getRow($query, array($id));
        return $result;       
    }
 
    public function findAll()
    {
        $query = "SELECT 
                    arti.*, cate.cate_name as cate_name,
                    TO_CHAR(arti.created_at, 'YYYY-MM-DD HH24:MI:SS') AS created_at, 
                    TO_CHAR(arti.updated_at, 'YYYY-MM-DD HH24:MI:SS') AS updated_at,                    
                    json_build_object('values',                   
                        (
                            SELECT 
                                json_agg(json_build_object('ts_id', ts.id, 'ts_name', ts.ts_name))
                            FROM 
                                articles_tags ats
                            LEFT JOIN 
                                tags ts ON ats.ts_id = ts.id
                            WHERE 
                                ats.arti_id = arti.id
                        
                        )
                    ) AS articles_tags
                FROM 
                    articles arti
                LEFT JOIN 
                    categories cate ON arti.cate_id = cate.id        
                ORDER BY 
                    arti.id DESC";

        $result = R::getAll($query);
        return $result;
    }
  
    public function add($data)
    {
        $articles = R::dispense('articles');
        $articles->arti_title = $data['arti_title'];
        $articles->arti_content = $data['arti_content'];
        $articles->arti_order = $data['arti_order'];
        $articles->cate_id = $data['cate_id'];
        $id = R::store($articles);
        return $id;
    }
 
    public function edit($data, $id)
    {
        $articles = R::load('articles', $id);
        $articles->arti_title = $data['arti_title'];
        $articles->arti_content = $data['arti_content'];
        $articles->arti_order = $data['arti_order'];
        $articles->cate_id = $data['cate_id'];
        $articles->updated_at = Time::getNow();
        R::store($articles);
    }
  
    public function delete($id)
    {
        $articles = R::load('articles', $id);
        R::trash($articles);
    }
    
}
