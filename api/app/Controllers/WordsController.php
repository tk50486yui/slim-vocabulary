<?php

namespace app\Controllers;

use app\Validations\WordsValidation;
use app\Models\Words;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class WordsController
{
    
    /* 查詢單一資料 words id = ? */
    public function find($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();

        try {

            $result = $WordsModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            return $MsgHandler->handleServerError($response);
        }       

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 words */
    public function findAll($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
     
        try {

            $result = $WordsModel->findAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增add單一資料 words */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsValidation= new WordsValidation();
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
       
        try {
            // 檢查 $data 格式
            if (!$WordsValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // 檢查有沒有重複的單詞          
            if ($WordsModel->findByName($data['ws_name']) != null) {
                return $MsgHandler->handleDuplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsModel->add($data);
            R::commit();
            // Transaction --結束--   
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);
    }

    /* 修改 edit 資料 words */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsValidation= new WordsValidation();
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$WordsValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // Transaction --開始--
            R::begin();
            $WordsModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束--            
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);
    }

    /* 查詢 words left join categories */
    public function findCategoriesAll($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();

        try {

            $result = $WordsModel->findCategoriesAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error   
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }
}
