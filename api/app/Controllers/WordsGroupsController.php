<?php

namespace app\Controllers;

use app\Models\WordsGroups;
use app\Validators\Tables\WordsGroupsValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

class WordsGroupsController
{

    /* 查詢單一資料 WordsGroups id = ? */
    public function find($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {

            $result = $WordsGroupsModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error   
            return MsgH::handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroups */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {

            $result = $WordsGroupsModel->findAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            return MsgH::handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增單一資料 WordsGroups */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsValidator = new WordsGroupsValidator();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsValidator->validate($data)) {
                return MsgH::handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return MsgH::handleDataProcessingFaild($response);
        }

        return MsgH::handleSuccess($response);
    }

    /* 修改 edit 資料 WordsGroups */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsValidator = new WordsGroupsValidator();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsValidator->validate($data)) {
                return MsgH::handleInvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsModel->edit($data, $args['id']);
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
