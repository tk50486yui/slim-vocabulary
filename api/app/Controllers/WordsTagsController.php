<?php

namespace app\Controllers;

use app\Models\WordsTags;
use app\Models\Words;
use app\Models\Tags;
use libs\Responses\MsgHandler;
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
            if($Words->find($data['ws_id']) == null || $Tags->find($data['ts_id']) == null){
                return $MsgHandler->handleNotFound($response);
            }
            // 再判斷所新增的關聯資料是否已經建立
            if($WordsTagsModel->findByAssociatedIDs($data) != null){
                return $MsgHandler->handleDuplicate($response);
            }
            
            $result = $WordsTagsModel->add($data);
           
            if ($result == true) {
                return $MsgHandler->handleSuccess($response);
            } else {
                return $MsgHandler->handleDataFaild($response);
            }
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error 
            return $MsgHandler->handleServerError($response);
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

            $result = $WordsTagsModel->delete($args['id']);

            if ($result == true) {
                return $MsgHandler->handleDeletion($response);
            } else {
                return $MsgHandler->handleDataFaild($response);
            }

        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }
    }

    /* 查詢所有資料 WordsTags 關聯 Words Tags*/
    public function findAll($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();             

        try {

            $result = $WordsTagsModel->findAll();

        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 以 tags id 查詢所有資料 WordsTags 關聯 Words Tags*/
    public function findByTagsID($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();             

        try {

            $result = $WordsTagsModel->findByTagsID($args['id']);

        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }
}
