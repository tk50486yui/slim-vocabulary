<?php

namespace app\Controllers;

use app\Models\WordsGroupsDetails;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class WordsGroupsDetailsController
{
    /* 查詢單一資料 WordsGroupsDetails id = ? */
    public function find($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();

        try {

            $result = $WordsGroupsDetailsModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroupsDetails */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();

        try {

            $result = $WordsGroupsDetailsModel->findAll();
                      
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);        
    }

    /* 新增單一資料 WordsGroupsDetails */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsDetailsModel->add($data);
            R::commit();
            // Transaction --結束--            
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);       
    }

    /* 刪除關聯資料 WordsGroupsDetails */
    public function delete($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 id 是否存在          
            if ($WordsGroupsDetailsModel->find($args['id']) == null) {
                return $MsgHandler->handleNotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsDetailsModel->delete($args['id']);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            // 資料處理失敗            
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleDeletion($response);       
    }
}
