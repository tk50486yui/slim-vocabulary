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
        $articles->arti_order = is_numeric($data['arti_order'])? (int)$data['arti_order'] : 1;
        $articles->cate_id = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;
        R::store($articles);
    }

    /* 修改 edit 資料 articles */
    public function edit($data, $id)
    {
        $articles = R::load('articles', $id);
        $articles->arti_title = $data['arti_title'];
        $articles->arti_content = $data['arti_content'];
        $articles->arti_order = is_numeric($data['arti_order'])? (int)$data['arti_order'] : 1;
        $articles->cate_id = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;
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
