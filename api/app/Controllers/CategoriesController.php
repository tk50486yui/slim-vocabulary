<?php

namespace app\Controllers;

use app\Models\Categories;
use libs\Responses\Msg;
use libs\Responses\MsgHandler;
use Exception;

class CategoriesController
{
    protected $CategoriesModel;
    protected $MsgHandler;
    protected $Msg;
    
    /* 查詢單一資料 Categories id = ? */ 
    public function find($request, $response, $args)
    {
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();      

        try {

            $result = $CategoriesModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Categories */ 
    public function findAll($request, $response, $args)
    {
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();       

        try {

            $result = $CategoriesModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }

    /* 新增單一資料 Categories */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();       

        try {
            /* 檢查有沒有重複的名稱 */
            $check = $CategoriesModel->findByName($data['cate_name']);
            if($check == false){
                return $MsgHandler->handleDuplicate($response, $Msg->msg);
            }
            /* 新增 */ 
            $result = $CategoriesModel->add($data);

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

    /* 修改 edit 資料 Categories */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
      
        try {

            $result = $CategoriesModel->edit($data, $args['id']);

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

    /* JOIN查詢 Categories id 底下的 words */ 
    public function findWordsByID($request, $response, $args)
    {
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
       
        try {

            $result = $CategoriesModel->findWordsByID($args['id']);

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
}
