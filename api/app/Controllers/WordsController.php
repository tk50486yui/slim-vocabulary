<?php

namespace app\Controllers;

use app\Models\Words;
use libs\Responses\MsgHandler;
use Exception;

class WordsController
{
   
    /* 查詢單一資料 words id = ? */ 
    public function find($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();         

        try {

            $result = $WordsModel->find($args['id']);

        } catch (Exception $e) {           
             // 出錯統一用 Internal Server Error           
             return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 words */ 
    public function findAll($request, $response, $args)
    {
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();       

        try {

            $result = $WordsModel->findAll();

        } catch (Exception $e) {  
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增add單一資料 words */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();    

        try {
            // 檢查有沒有重複的單詞          
            if($WordsModel->findByName($data['ws_name']) != null){
                return $MsgHandler->handleDuplicate($response);
            }
         
            $result = $WordsModel->add($data);

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

    /* 修改 edit 資料 words */ 
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();          

        try {

            $result = $WordsModel->edit($data, $args['id']);

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

    /* 查詢 words left join categories */ 
    public function findCategoriesAll($request, $response, $args)
    {    
        $WordsModel = new Words();
        $MsgHandler = new MsgHandler();
     
        try {

            $result = $WordsModel->findCategoriesAll();           

        } catch (Exception $e) {   
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }
       
        return $response->withJson($result, 200);
    }
}
