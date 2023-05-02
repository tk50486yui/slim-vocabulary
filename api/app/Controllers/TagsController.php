<?php

namespace app\Controllers;

use app\Models\Tags;
use libs\Responses\MsgHandler;
use Exception;

class TagsController
{
  
    /* 查詢單一資料 Tags id = ? */ 
    public function find($request, $response, $args)
    {
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();     
       
        try {

            $result = $TagsModel->find($args['id']);

        } catch (Exception $e) {           
             // 出錯統一用 Internal Server Error           
             return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Tags */ 
    public function findAll($request, $response, $args)
    {
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();      
      
        try {

            $result = $TagsModel->findAll();

        } catch (Exception $e) {  
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 Tags */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();    

        try {
            // 檢查有沒有重複的標籤名稱      
            if($TagsModel->findByName($data['ts_name']) != null){
                return $MsgHandler->handleDuplicate($response);
            }
           
            $result = $TagsModel->add($data);

            if($result == true){
                return $MsgHandler->handleSuccess($response);
            }else{
                return $MsgHandler->handleDataFaild($response);
            }
            

        } catch (Exception $e) {  
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }
       
    }

    /* 修改 edit 資料 Tags */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();    
       
        try {

            $result = $TagsModel->edit($data, $args['id']);

            if($result == true){
                return $MsgHandler->handleSuccess($response);
            }else{
                return $MsgHandler->handleDataFaild($response);
            }

        } catch (Exception $e) {   
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }
       
    }
}
