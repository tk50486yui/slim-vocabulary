<?php

namespace app\Controllers;

use app\Models\ArticlesWords;
use app\Validators\tables\ArticlesWordsValidator;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class ArticlesWordsController
{

    /* 查詢單一資料 ArticlesWords id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();

        try {

            $result = $ArticlesWordsModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 ArticlesWords */
    public function findAll($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();

        try {
            
            $result = $ArticlesWordsModel->findAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 ArticlesWords */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesWordsModel = new ArticlesWords();
        $ArticlesWordsValidator = new ArticlesWordsValidator();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$ArticlesWordsValidator->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // 再判斷所新增的關聯鍵是否已經存在 避免重複建立
            if ($ArticlesWordsModel->findByAssociatedIDs($data) != null) {
                return $MsgHandler->handleDuplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesWordsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);
    }

    /* 刪除關聯資料 ArticlesWords */
    public function delete($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 id 是否存在             
            if ($ArticlesWordsModel->find($args['id']) == null) {
                return $MsgHandler->handleNotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $$ArticlesWordsModel->delete($args['id']);
            R::commit();
            // Transaction --結束--
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleDeletion($response);
    }
}
