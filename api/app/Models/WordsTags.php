<?php

namespace app\Models;

use \RedBeanPHP\R as R;

class WordsTags
{
   
    public function find($id)
    {
        $result = R::findOne('words_tags', ' id = ? ', array($id));
        return $result;
    }
  
    public function findByAssociatedIDs($ws_id, $ts_id)
    {
        // binding 的長度必須一致
        $keyword = array(
            "ws_id" => $ws_id,
            "ts_id" => $ts_id
        );
        $result = R::findOne('words_tags', ' ws_id = :ws_id AND ts_id = :ts_id', $keyword);        
        return $result;
    }
  
    public function add($data)
    {
        // 使用自訂義 xdispense
        $words_tags = R::xdispense('words_tags');
        $words_tags->ts_id = $data['ts_id'];
        $words_tags->ws_id = $data['ws_id'];
        R::store($words_tags);
    }
  
    public function delete($id)
    {
        $words_tags = R::load('words_tags', $id);
        R::trash($words_tags);
    }

    /* JOIN 查詢 關聯 words 與 tags 全部資料 */
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

    /* JOIN 查詢 */
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

    /* JOIN 查詢 */
    public function findByWordsID($ws_id)
    {
        $query = "SELECT 
                    ts.id as ts_id, ts.ts_name
                FROM 
                    words_tags wt                   
                LEFT JOIN  words ws ON wt.ws_id = ws.id 
                LEFT JOIN tags ts ON wt.ts_id =  ts.id
                WHERE 
                    wt.ws_id = ?";

        $result = R::getAll($query, array($ws_id));

        return $result;
    }
}
