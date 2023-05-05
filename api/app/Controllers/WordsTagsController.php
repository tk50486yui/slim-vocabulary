<?php

namespace app\Controllers;

use app\Models\WordsTags;
use app\Validations\WordsTagsValidation;
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
        $WordsTagsValidation = new WordsTagsValidation();
        $MsgHandler = new MsgHandler();             

        try {
            // 檢查 $data 格式
            if (!$WordsTagsValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // 再判斷所新增的關聯鍵是否已經存在 避免重複建立
            if ($WordsTagsModel->findByAssociatedIDs($data) != null) {
                return $MsgHandler->handleDuplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsTagsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);        
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
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleDeletion($response);
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
