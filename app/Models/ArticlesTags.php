<?php

namespace app\Models;

use \RedBeanPHP\R as R;

class ArticlesTags
{
  
    public function find($id)
    {
        $result = R::findOne('articles_tags', ' id = ? ', array($id));
        return $result;
    }

    public function findAll()
    {
        $result = R::findAll('articles_tags');
        return $result;
    }

    public function findByAssociatedIDs($arti_id, $ts_id)
    {
        // binding 的長度必須一致
        $keyword = array(
            "arti_id" => $arti_id,
            "ts_id" => $ts_id
        );
        $result = R::findOne('articles_tags', ' arti_id = :arti_id AND ts_id = :ts_id', $keyword);        
        return $result;
    }
 
    public function add($data)
    {
        // 使用自訂義 xdispense
        $articles_tags = R::xdispense('articles_tags');
        $articles_tags->arti_id = $data['arti_id'];
        $articles_tags->ts_id = $data['ts_id'];
        R::store($articles_tags);
    } 

    /** 尋找這個 articles 底下所有的 tags */
    public function findByArticlesID($arti_id)
    {
        $query = "SELECT 
                    ts.id as ts_id, ts.ts_name
                FROM 
                    articles_tags ats                   
                LEFT JOIN articles arti ON ats.arti_id = arti.id 
                LEFT JOIN tags ts ON ats.ts_id =  ts.id
                WHERE 
                    ats.arti_id = ?";

        $result = R::getAll($query, array($arti_id));

        return $result;
    }

    public function deleteByArtiID($id)
    {    
        R::hunt('articles_tags', 'arti_id = ?', array($id));
    }
    
}
