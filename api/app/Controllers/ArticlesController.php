<?php

namespace app\Controllers;

use app\Models\Articles;
use libs\Responses\Msg;
use libs\Responses\MsgHandler;
use Exception;

class ArticlesController
{
    protected $ArticlesModel;
    protected $MsgHandler;
    protected $Msg;

    /* 查詢單一資料 Articles id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();      

        try {

            $result = $ArticlesModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Articles */ 
    public function findAll($request, $response, $args)
    {
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
       
        try {

            $result = $ArticlesModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 Articles */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();      

        try {
           
            /* 新增 */ 
            $result = $ArticlesModel->add($data);

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

    /* 修改 edit 資料 Articles */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $ArticlesModel = new Articles();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();        

        try {

            $result = $ArticlesModel->edit($data, $args['id']);

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
