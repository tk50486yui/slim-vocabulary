<?php

namespace app\Controllers;

use app\Models\WordsTags;
use app\Models\Words;
use app\Models\Tags;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class WordsTagsController
{

    /* 新增單一資料 WordsTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();
        $Words = new Words();
        $Tags = new Tags();

        try {
            // 先判斷所參考的外鍵表格資料是否存在 若有其中一個不存在就直接return
            // 這邊若過了就代表資料是整數字串而非其他字元 所以之後不用再另外判斷
            if ($Words->find($data['ws_id']) == null || $Tags->find($data['ts_id']) == null) {
                return $MsgHandler->handleNotFound($response);
            }
            // 再判斷所新增的關聯資料是否已經建立
            if ($WordsTagsModel->findByAssociatedIDs($data) != null) {
                return $MsgHandler->handleDuplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsTagsModel->add($data);
            R::commit();
            // Transaction --結束--  
            R::close();
            return $MsgHandler->handleSuccess($response);
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            R::close();
            return $MsgHandler->handleDataProcessingFaild($response);
        }
        
    }

    /* 刪除關聯資料 WordsTags */
    public function delete($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 id 是否存在                     
            if ($WordsTagsModel->find($args['id']) == null) {
                return $MsgHandler->handleNotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsTagsModel->delete($args['id']);
            R::commit();
            // Transaction --結束--       
            R::close();
            return $MsgHandler->handleDeletion($response);
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            R::close();
            return $MsgHandler->handleDataProcessingFaild($response);
        }
       
    }

    /* 查詢所有資料 WordsTags 關聯 Words Tags*/
    public function findAll($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();

        try {
            $result = $WordsTagsModel->findAll();            
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            R::close();
            return $MsgHandler->handleServerError($response);
        }
        
    }

    /* 以 tags id 查詢所有資料 WordsTags 關聯 Words Tags*/
    public function findByTagsID($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();

        try {
            $result = $WordsTagsModel->findByTagsID($args['id']);
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            R::close();
            return $MsgHandler->handleServerError($response);
        }
       
    }
}
