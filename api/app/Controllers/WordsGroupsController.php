<?php

namespace app\Controllers;

use app\Models\WordsGroups;
use app\Validations\WordsGroupsValidation;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class WordsGroupsController
{

    /* 查詢單一資料 WordsGroups id = ? */
    public function find($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();

        try {

            $result = $WordsGroupsModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error   
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroups */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();

        try {

            $result = $WordsGroupsModel->findAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增單一資料 WordsGroups */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsValidation = new WordsGroupsValidation();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);
    }

    /* 修改 edit 資料 WordsGroups */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsValidation = new WordsGroupsValidation();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsValidation->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsModel->edit($data, $args['id']);
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
