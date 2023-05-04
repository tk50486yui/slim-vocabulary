<?php

namespace app\Controllers;

use app\Models\WordsGroups;
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
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error   
            R::close();
            return $MsgHandler->handleServerError($response);
        }
    }

    /* 查詢所有資料 WordsGroups */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();

        try {
            $result = $WordsGroupsModel->findAll();
            R::close();
            return $response->withJson($result, 200);
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            R::close();
            return $MsgHandler->handleServerError($response);
        }
    }

    /* 新增單一資料 WordsGroups */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsModel->add($data);
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

    /* 修改 edit 資料 WordsGroups */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsModel->edit($data, $args['id']);
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
