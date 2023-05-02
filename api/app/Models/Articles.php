<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Customs\Time;
use Exception;

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
        $result = false;
        // Transaction
        R::begin();
        try {
            $articles = R::dispense('articles');
            $articles->arti_title = $data['arti_title'];
            $articles->arti_content = $data['arti_content'];
            $articles->arti_order = $data['arti_order'];
            $articles->cate_id = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;
            R::store($articles);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* 修改 edit 資料 articles */
    public function edit($data, $id)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            $articles = R::load('articles', $id);
            $articles->arti_title = $data['arti_title'];
            $articles->arti_content = $data['arti_content'];
            $articles->arti_order = $data['arti_order'];
            $articles->cate_id = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;
            $articles->updated_at = Time::getNow();
            R::store($articles);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* 刪除關聯資料 articles */
    public function delete($id)
    {
        $result = false;
        // Transaction
        R::begin();

        try {
            $articles = R::load('articles', $id);
            R::trash($articles);
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
