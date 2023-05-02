<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use Exception;

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

    /* 新增單一資料 articles_tags */
    public function add($data)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            $articles_tags = R::dispense('articles_tags');            
            $articles_tags->arti_id = is_numeric($data['arti_id']) ? (int)$data['arti_id'] : null;
            $articles_tags->ts_id = is_numeric($data['ts_id']) ? (int)$data['ts_id'] : null;         
            R::store($articles_tags);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* 刪除關聯資料 articles_tags */
    public function delete($id)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            $articles_tags = R::load('articles_tags', $id);
            R::trash($articles_tags);
            R::commit();
            R::close();
            $result = true;

        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }
}
