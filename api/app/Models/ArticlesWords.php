<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

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
        $result = false;
        /* Transaction */
        R::begin();
        try {
            $articles_words = R::dispense('articles_words');            
            $articles_words->arti_id = is_numeric($data['arti_id']) ? (int)$data['arti_id'] : null;
            $articles_words->ws_id = is_numeric($data['ws_id']) ? (int)$data['ws_id'] : null;         
            R::store($articles_words);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }
    /* 修改edit資料 articles_words */
    public function edit($data, $id)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {

            $articles_words = R::load('articles_words', $id);
            $articles_words->arti_id = is_numeric($data['arti_id']) ? (int)$data['arti_id'] : null;
            $articles_words->ws_id = is_numeric($data['ws_id']) ? (int)$data['ws_id'] : null;             
            $articles_words->updated_at = Time::getNow();
            R::store($articles_words);
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
