<?php

namespace app\Controllers;

use app\Models\Articles;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class ArticlesController
{

    /* 查詢單一資料 Articles id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();

        try {
            $result = $ArticlesModel->find($args['id']);
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error 
            R::close();                      
            return $MsgHandler->handleServerError($response);
        }        
    }

    /* 查詢所有資料 Articles */
    public function findAll($request, $response, $args)
    {
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();

        try {
            $result = $ArticlesModel->findAll();
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {            
            // 出錯統一用 Internal Server Error  
            R::close();         
            return $MsgHandler->handleServerError($response);
        }        
    }

    /* 新增單一資料 Articles */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $ArticlesModel->add($data);
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

    /* 修改 edit 資料 Articles */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $ArticlesModel->edit($data, $args['id']);
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
}
