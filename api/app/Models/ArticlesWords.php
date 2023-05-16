<?php

namespace app\Models;

use \RedBeanPHP\R as R;

class ArticlesWords
{
   
    public function find($id)
    {
        $result = R::findOne('articles_words', ' id = ? ', array($id));
        return $result;
    }

  
    public function findAll()
    {
        $result = R::findAll('articles_words');
        return $result;
    }
 
    public function findByAssociatedIDs($arti_id, $ws_id)
    {
        // binding 的長度必須一致
        $keyword = array(
            "arti_id" => $arti_id,
            "ws_id" => $ws_id
        );
        $result = R::findOne('articles_words', ' arti_id = :arti_id AND ws_id = :ws_id', $keyword);        
        return $result;
    }
  
    public function add($data)
    {
        // 使用自訂義 xdispense
        $articles_words = R::xdispense('articles_words');
        $articles_words->arti_id = $data['arti_id'];
        $articles_words->ws_id = $data['ws_id'];
        R::store($articles_words);
    }
   
    public function delete($id)
    {
        $articles_words = R::load('articles_words', $id);
        R::trash($articles_words);
    }
    
}
