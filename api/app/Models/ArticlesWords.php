<?php

namespace app\Models;

use Exception;
use app\Time;
use \RedBeanPHP\R as R;

class ArticlesWords
{
    const TABLE_NAME = 'articles_words';

    /* 查詢單一資料 articles_words  id = ? */
    public function find($id)
    {
        $result = R::findOne(SELF::TABLE_NAME, ' id = ? ', array($id));

        return $result;
    }

    /* 查詢所有資料 articles_words */
    public function findAll()
    {

        $result = R::findAll(SELF::TABLE_NAME);

        return $result;
    }

    /* 新增單一資料 articles_words */
    public function add($data)
    {
        $result = false;
        /* Transaction */
        R::begin();
        try {
            $articles_words = R::dispense(SELF::TABLE_NAME);
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

    /* 刪除關聯資料 articles_words */
    public function delete($id)
    {
        $result = false;
        /* Transaction */
        R::begin();

        try {
            $articles_words = R::load(SELF::TABLE_NAME, $id);
            R::trash($articles_words);
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
