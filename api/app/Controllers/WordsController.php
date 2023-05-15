<?php

namespace app\Controllers;

use app\Factories\WordsFactory;
use app\Models\Words;
use \RedBeanPHP\R as R;
use Exception;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use libs\Responses\MsgHandler as MsgH;

class WordsController
{

    /* 查詢單一資料 words id = ? */
    public function find($request, $response, $args)
    {
        $WordsModel = new Words();        

        try {
            $result = $WordsModel->find($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
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
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增add單一資料 words */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsFactory = new WordsFactory();
        $WordsModel = new Words();
        $ExceptionHF = new ExceptionHandlerFactory();       

        try {          
            $newData = $WordsFactory->createFactory($data);
            // Transaction --開始-- 
            R::begin();
            $WordsModel->add($newData);
            R::commit();
            // Transaction --結束--   
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::success($response);
    }

    /* 修改 edit 資料 words */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsFactory = new WordsFactory();
        $WordsModel = new Words();
        $ExceptionHF = new ExceptionHandlerFactory();

        try {
            $newData = $WordsFactory->createFactory($data);
            // Transaction --開始--
            R::begin();
            $WordsModel->edit($newData, $args['id']);
            R::commit();
            // Transaction --結束--            
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {         
            R::rollback();
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::success($response);
    }
}
