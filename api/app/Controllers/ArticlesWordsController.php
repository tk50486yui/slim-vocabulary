<?php

namespace app\Controllers;

use app\Models\ArticlesWords;
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
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            R::close();
            return $MsgHandler->handleServerError($response);
        }
    }

    /* 查詢所有資料 ArticlesWords */
    public function findAll($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();

        try {
            $result = $ArticlesWordsModel->findAll();
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            R::close();
            return $MsgHandler->handleServerError($response);
        }
    }
    /* 新增單一資料 ArticlesWords */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $ArticlesWordsModel->add($data);
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
            R::close();
            return $MsgHandler->handleDeletion($response);
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            R::close();
            return $MsgHandler->handleDataProcessingFaild($response);
        }
    }
}
