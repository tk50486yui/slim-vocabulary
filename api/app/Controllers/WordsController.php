<?php

namespace app\Controllers;

use app\Models\Words;
use app\Msg;
use app\DatabaseManager;
use app\MsgHandler;
use Exception;

class WordsController
{
    protected $WordsModel;
    protected $MsgHandler;
    protected $Msg;
    /* 查詢單一資料 words id = ? */ 
    public function find($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $WordsModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 查詢所有資料 words */ 
    public function findAll($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $WordsModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 新增add單一資料 words */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();

        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {
            /* 檢查有沒有重複的單詞 */
            $check = $WordsModel->findByName($data['ws_name']);
            if($check == false){
                return $MsgHandler->handleDuplicate($response, $Msg->msg);
            }
            /* 新增 */ 
            $result = $WordsModel->add($data);

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

    /* 修改edit資料 words */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()){
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $WordsModel->edit($data, $args['id']);

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
