<?php

namespace app\Controllers;

use app\Models\Articles;
use app\Validators\Tables\ArticlesValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

class ArticlesController
{

    /* 查詢單一資料 Articles id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesModel = new Articles();

        try {

            $result = $ArticlesModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error                       
            return MsgH::handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Articles */
    public function findAll($request, $response, $args)
    {
        $ArticlesModel = new Articles();

        try {

            $result = $ArticlesModel->findAll();
            
        } catch (Exception $e) {            
            // 出錯統一用 Internal Server Error           
            return MsgH::handleServerError($response);
        }

        return $response->withJson($result, 200);   
    }

    /* 新增單一資料 Articles */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesModel = new Articles();
        $ArticlesValidator = new ArticlesValidator();

        try {
            // 檢查 $data 格式
            if (!$ArticlesValidator->validate($data)) {
                return MsgH::handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesModel->add($data);
            R::commit();
            // Transaction --結束--  
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return MsgH::handleDataProcessingFaild($response);
        }

        return MsgH::handleSuccess($response);        
    }

    /* 修改 edit 資料 Articles */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesModel = new Articles();
        $ArticlesValidator = new ArticlesValidator();
        
        try {
            // 檢查 $data 格式
            if (!$ArticlesValidator->validate($data)) {
                return MsgH::handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束--  
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return MsgH::handleDataProcessingFaild($response);
        }

        return MsgH::handleSuccess($response);
    }
}
