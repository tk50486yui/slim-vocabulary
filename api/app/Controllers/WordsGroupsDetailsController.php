<?php

namespace app\Controllers;

use app\Models\WordsGroupsDetails;
use libs\Responses\Msg;
use libs\Responses\MsgHandler;
use Exception;

class WordsGroupsDetailsController
{
    protected $WordsGroupsDetailsModel;
    protected $MsgHandler;
    protected $Msg;

    /* 查詢單一資料 WordsGroupsDetails id = ? */ 
    public function find($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
      
        try {

            $result = $WordsGroupsDetailsModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroupsDetails */ 
    public function findAll($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
       
        try {

            $result = $WordsGroupsDetailsModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 WordsGroupsDetails */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();

        try {
           
            /* 新增 */ 
            $result = $WordsGroupsDetailsModel->add($data);

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

    /* 刪除關聯資料 WordsGroupsDetails */ 
    public function edit($request, $response, $args)
    {              
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
       
        try {

            /* 檢查 id 是否存在 */
            $check = $WordsGroupsDetailsModel->find($args['id']);
            if ($check == false) {
                return $MsgHandler->handleNotFound($response, $Msg->msg);
            }

            $result = $WordsGroupsDetailsModel->delete($args['id']);

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
