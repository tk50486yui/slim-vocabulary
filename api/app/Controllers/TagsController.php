<?php

namespace app\Controllers;

use app\Models\Tags;
use app\Msg;
use app\DatabaseManager;
use app\MsgHandler;
use Exception;

class TagsController
{
    protected $TagsModel;
    protected $MsgHandler;
    protected $Msg;
    /* 查詢單一資料 Tags id = ? */ 
    public function find($request, $response, $args)
    {
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $TagsModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 查詢所有資料 Tags */ 
    public function findAll($request, $response, $args)
    {
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $TagsModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 新增單一資料 Tags */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();

        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {
            /* 檢查有沒有重複的標籤名稱 */
            $check = $TagsModel->findByName($data['ts_name']);
            if($check == false){
                return $MsgHandler->handleDuplicate($response, $Msg->msg);
            }
            /* 新增 */ 
            $result = $TagsModel->add($data);

            if($result == true){
                return $MsgHandler->handleSuccess($response, $Msg->msg);
            }else{
                return $MsgHandler->handleDataFaild($response, $Msg->msg);
            }
            

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }
       
    }

    /* 修改edit資料 Tags */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $TagsModel->edit($data, $args['id']);

            if($result == true){
                return $MsgHandler->handleSuccess($response, $Msg->msg);
            }else{
                return $MsgHandler->handleDataFaild($response, $Msg->msg);
            }

        } catch (Exception $e) {   
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }
       
    }
}
