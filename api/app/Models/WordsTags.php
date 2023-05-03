<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Customs\ArrayMap;
use Exception;

class WordsTags
{    

    /* 查詢單一資料 words_tags  id = ? */
    public function find($id)
    {
        $result = R::findOne('words_tags', ' id = ? ', array($id));

        return $result;
    }

    /* 查詢資料 words_tags ws_id 及 ts_id */
    public function findByAssociatedIDs($data)
    {       
        $keyword = ArrayMap::getMap($data);
        $result = R::findOne('words_tags', ' ws_id = :ws_id AND ts_id = :ts_id', $keyword);

        return $result;
    }   

    /* 新增單一資料 words_tags */
    public function add($data)
    {
        $result = false;
        // Transaction   
        R::begin();
        try {
            // 使用自訂義 xdispense
            $words_tags = R::xdispense('words_tags');                  
            $words_tags->ts_id = (int)$data['ts_id'];
            $words_tags->ws_id = (int)$data['ws_id'];;
            R::store($words_tags);         
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false; 
        }

        return $result;
    }

    /* 刪除關聯資料 words_tags */
    public function delete($id)
    {
        $result = false;
        // Transaction
        R::begin();
        try {
            $words_tags = R::load('words_tags', $id);
            R::trash($words_tags);
            R::commit();
            R::close();
            $result = true;
        } catch (Exception $e) {
            R::rollback();
            $result = false;
        }

        return $result;
    }

    /* JOIN 查詢 words_tags LEFT JOIN words tags 全部資料 */
    public function findAll()
    {
        $query = "SELECT 
                    ws.*, ts.ts_name
                FROM 
                    words_tags wt
                LEFT JOIN words ws ON wt.ws_id =  ws.id
                LEFT JOIN tags ts ON wt.ts_id =  ts.id";

        $result = R::getAll($query);

        return $result;
    }

    /* JOIN 查詢 words_tags LEFT JOIN words tags WHERE ts_id */
    public function findByTagsID($ts_id)
    {
        $query = "SELECT 
                    ws.*, ts.ts_name
                FROM 
                    words_tags wt
                LEFT JOIN words ws ON wt.ws_id =  ws.id
                LEFT JOIN tags ts ON wt.ts_id =  ts.id
                WHERE 
                    wt.ts_id = ?";

        $result = R::getAll($query, array($ts_id));

        return $result;
    }
}
