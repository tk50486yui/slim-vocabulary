<?php

namespace app\Controllers;

use app\Models\Articles;
use app\Validations\ArticlesValidation;
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
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error                       
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Articles */
    public function findAll($request, $response, $args)
    {
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();

        try {

            $result = $ArticlesModel->findAll();
            
        } catch (Exception $e) {            
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);   
    }

    /* 新增單一資料 Articles */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesModel = new Articles();
        $ArticlesValidation = new ArticlesValidation();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$ArticlesValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesModel->add($data);
            R::commit();
            // Transaction --結束--  
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);        
    }

    /* 修改 edit 資料 Articles */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesModel = new Articles();
        $ArticlesValidation = new ArticlesValidation();
        $MsgHandler = new MsgHandler();
        
        try {
            // 檢查 $data 格式
            if (!$ArticlesValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束--  
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);
    }
}
