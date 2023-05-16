<?php

namespace app\Models;

use \RedBeanPHP\R as R;

class ArticlesTags
{

    /* 查詢單一資料 articles_tags  id = ? */
    public function find($id)
    {
        $result = R::findOne('articles_tags', ' id = ? ', array($id));
        return $result;
    }

    /* 查詢所有資料 articles_tags */
    public function findAll()
    {
        $result = R::findAll('articles_tags');
        return $result;
    }

    /* 查詢資料 articles_words ws_id 及 ts_id */
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

    /* 新增單一資料 articles_tags */
    public function add($data)
    {
        // 使用自訂義 xdispense
        $articles_tags = R::xdispense('articles_tags');
        $articles_tags->arti_id = $data['arti_id'];
        $articles_tags->ts_id = $data['ts_id'];
        R::store($articles_tags);
    }

    /* 刪除關聯資料 articles_tags */
    public function delete($id)
    {
        $articles_tags = R::load('articles_tags', $id);
        R::trash($articles_tags);
    }
}
