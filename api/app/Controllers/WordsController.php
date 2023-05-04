<?php

namespace app\Controllers;

use app\Models\Words;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;
use libs\Responses\Test;

class WordsController
{
    /* 查詢單一資料 words id = ? */
    public function find($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();

        try {
            $result = $WordsModel->find($args['id']);
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            R::close();
            return $MsgHandler->handleServerError($response);
        }       
    }

    /* 查詢所有資料 words */
    public function findAll($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
     
        try {
            $result = $WordsModel->findAll();
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            R::close();
            return $MsgHandler->handleServerError($response);
        }
    }

    /* 新增add單一資料 words */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
        try {
            // 檢查空值或null
            if (empty($data['ws_name'])) {
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
            R::close();
            return $MsgHandler->handleSuccess($response);
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            R::close();
            return $MsgHandler->handleDataProcessingFaild($response);
        }
    }

    /* 修改 edit 資料 words */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始--
            R::begin();
            $WordsModel->edit($data, $args['id']);
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

    /* 查詢 words left join categories */
    public function findCategoriesAll($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();

        try {
            $result = $WordsModel->findCategoriesAll();
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error   
            R::close();
            return $MsgHandler->handleServerError($response);
        }
    }
}
