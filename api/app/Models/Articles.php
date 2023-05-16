<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class Articles
{

    /* 查詢單一資料 articles  id = ? */
    public function find($id)
    {
        $result = R::findOne('articles', ' id = ? ', array($id));
        return $result;
    }

    /* 查詢所有資料 articles */
    public function findAll()
    {
        $result = R::findAll('articles');
        return $result;
    }

    /* 新增單一資料 articles */
    public function add($data)
    {
        $articles = R::dispense('articles');
        $articles->arti_title = $data['arti_title'];
        $articles->arti_content = $data['arti_content'];
        $articles->arti_order = $data['arti_order'];
        $articles->cate_id = $data['cate_id'];
        R::store($articles);
    }

    /* 修改 edit 資料 articles */
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

    /* 刪除關聯資料 articles */
    public function delete($id)
    {
        $articles = R::load('articles', $id);
        R::trash($articles);
    }
}
