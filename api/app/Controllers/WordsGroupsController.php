<?php

namespace app\Controllers;

use app\Models\WordsGroups;
use libs\Responses\Msg;
use libs\Responses\MsgHandler;
use Exception;

class WordsGroupsController
{
    protected $WordsGroupsModel;
    protected $MsgHandler;
    protected $Msg;

    /* 查詢單一資料 WordsGroups id = ? */ 
    public function find($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
       
        try {

            $result = $WordsGroupsModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroups */ 
    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
      
        try {

            $result = $WordsGroupsModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 WordsGroups */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();

        try {
           
            /* 新增 */ 
            $result = $WordsGroupsModel->add($data);

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

    /* 修改 edit 資料 WordsGroups */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsGroupsModel = new WordsGroups();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
       
        try {

            $result = $WordsGroupsModel->edit($data, $args['id']);

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
