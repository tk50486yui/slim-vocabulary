<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class Articles
{
  
    public function find($id)
    {
        $result = R::findOne('articles', ' id = ? ', array($id));
        return $result;
    }
 
    public function findAll()
    {
        $query = "SELECT 
                    id, arti_title, arti_content, arti_order, cate_id,
                    TO_CHAR(created_at, 'YYYY-MM-DD HH24:MI:SS') AS created_at, 
                    TO_CHAR(updated_at, 'YYYY-MM-DD HH24:MI:SS') AS updated_at
                FROM 
                    articles             
                ORDER BY 
                    id DESC";

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
        R::store($articles);
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
