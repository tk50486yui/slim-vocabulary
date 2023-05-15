<?php

namespace app\Controllers;

use app\Factories\WordsFactory;
use app\Models\Words;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;

class WordsController
{
    
    /* 查詢單一資料 words id = ? */
    public function find($request, $response, $args)
    {        
        $WordsModel = new Words();

        try {
         
            $result = $WordsModel->find($args['id']);
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error    
            return MsgH::handleServerError($response);
        }       

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 words */
    public function findAll($request, $response, $args)
    {
        $WordsModel = new Words();
     
        try {

            $result = $WordsModel->findAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error
            return MsgH::handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增add單一資料 words */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsFactory = new WordsFactory();
        $WordsModel = new Words();
        $handlerChain = ExceptionHandlerFactory::createExceptionHandlerChain();
       
        try {       
           
            //return $WordsEntity->cate_id;  
            $d=$WordsFactory->createFactory($data);
           
            /*if(!$WordsEntity->validate()){
                return MsgH::handleInvalidData($response);
            }*/
            return $d->cate_id;
            /*// 檢查 $data 格式
            if (!$WordsValidator->validate($data)) {
                return MsgH::handleInvalidData($response);
            }*/
            // 檢查有沒有重複的單詞          
            if ($WordsModel->findByName($data['ws_name']) != null) {
                return MsgH::handleDuplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsModel->add($data);
            R::commit();
            // Transaction --結束--   
        }catch (BaseExceptionCollection $e) {
            return $handlerChain->handleException($e, $response);            
        }catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return MsgH::handleDataProcessingFaild($response);
        }

        return MsgH::handleSuccess($response);
    }

    /* 修改 edit 資料 words */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        //$WordsValidator= new WordsValidator();
        $WordsModel = new Words();

        try {
            /*// 檢查 $data 格式
            if (!$WordsValidator->validate($data)) {
                return MsgH::handleInvalidData($response);
            }*/
            // Transaction --開始--
            R::begin();
            $WordsModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束--            
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return MsgH::handleDataProcessingFaild($response);
        }

        return MsgH::handleSuccess($response);
    }
   
}
