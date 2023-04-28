<?php

namespace app\Controllers;

use app\Models\ArticlesWords;
use libs\Responses\Msg;
use libs\Responses\MsgHandler;
use Exception;

class ArticlesWordsController
{
    protected $ArticlesWordsModel;
    protected $MsgHandler;
    protected $Msg;
    
    /* 查詢單一資料 ArticlesWords id = ? */ 
    public function find($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();       

        try {

            $result = $ArticlesWordsModel->find($args['id']);

        } catch (Exception $e) {           
             /* 出錯統一用 Internal Server Error */           
             return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 ArticlesWords */ 
    public function findAll($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();       

        try {

            $result = $ArticlesWordsModel->findAll();

        } catch (Exception $e) {  
            /* 出錯統一用 Internal Server Error */           
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 新增單一資料 ArticlesWords */ 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();     

        try {
           
            /* 新增 */ 
            $result = $ArticlesWordsModel->add($data);

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

    /* 刪除關聯資料 ArticlesWords */ 
    public function delete($request, $response, $args)
    {               
        $ArticlesWordsModel = new ArticlesWords();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();      

        try {

            /* 檢查 id 是否存在 */
            $check =  $ArticlesWordsModel->find($args['id']);
            if ($check == false) {
                return $MsgHandler->handleNotFound($response, $Msg->msg);
            }

            $result = $ArticlesWordsModel->delete($args['id']);

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
