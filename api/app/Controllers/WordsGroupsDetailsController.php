<?php

namespace app\Controllers;

use app\Models\WordsGroupsDetails;
use libs\Responses\MsgHandler;
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
        
            $result = $WordsGroupsDetailsModel->add($data);

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

    /* 刪除關聯資料 WordsGroupsDetails */ 
    public function edit($request, $response, $args)
    {              
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();   
       
        try {

            // 檢查 id 是否存在          
            if ($WordsGroupsDetailsModel->find($args['id']) == null) {
                return $MsgHandler->handleNotFound($response);
            }

            $result = $WordsGroupsDetailsModel->delete($args['id']);

            if($result == true){
                return $MsgHandler->handleDeletion($response);
            }else{
                return $MsgHandler->handleDataFaild($response);
            }

        } catch (Exception $e) {   
            // 出錯統一用 Internal Server Error
            return $MsgHandler->handleServerError($response);
        }
       
    }
}
