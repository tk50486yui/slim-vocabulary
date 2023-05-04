<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use Exception;

class ArticlesWords
{

    /* 查詢單一資料 articles_words  id = ? */
    public function find($id)
    {
        $result = R::findOne('articles_words', ' id = ? ', array($id));
        return $result;
    }

    /* 查詢所有資料 articles_words */
    public function findAll()
    {
        $result = R::findAll('articles_words');
        return $result;
    }

    /* 新增單一資料 articles_words */
    public function add($data)
    {
        // 使用自訂義 xdispense
        $articles_words = R::xdispense('articles_words');
        $articles_words->arti_id = (int)$data['arti_id'];
        $articles_words->ws_id = (int)$data['ws_id'];
        R::store($articles_words);
    }

    /* 刪除關聯資料 articles_words */
    public function delete($id)
    {
        $articles_words = R::load('articles_words', $id);
        R::trash($articles_words);
    }
}
