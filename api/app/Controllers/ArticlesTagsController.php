<?php

namespace app\Controllers;

use app\Models\ArticlesTags;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class ArticlesTagsController
{

    /* 查詢單一資料 ArticlesTags id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();

        try {
            $result = $ArticlesTagsModel->find($args['id']);
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            R::close();
            return $MsgHandler->handleServerError($response);
        }
        
    }

    /* 查詢所有資料 ArticlesTags */
    public function findAll($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();

        try {
            $result = $ArticlesTagsModel->findAll();
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            R::close();
            return $MsgHandler->handleServerError($response);
        }

        
    }

    /* 新增單一資料 ArticlesTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $ArticlesTagsModel->add($data);
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

    /* 刪除關聯資料 ArticlesTags */
    public function delete($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 id 是否存在        
            if ($ArticlesTagsModel->find($args['id']) == null) {
                return $MsgHandler->handleNotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesTagsModel->delete($args['id']);
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
