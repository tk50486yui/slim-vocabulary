<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\WordsFactory;
use app\Models\Words;

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
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsModel = new Words();      

        try {          
            $data = $WordsFactory->createFactory($data, null);           
            R::begin();
            $WordsModel->add($data);
            R::commit();         
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    /* 修改 edit 資料 words */
    public function edit($request, $response, $args)
    {      
        $data = $request->getParsedBody();
        $WordsFactory = new WordsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsModel = new Words();

        try {
            $data = $WordsFactory->createFactory($data, $args['id']);            
            R::begin();
            $WordsModel->edit($data, $args['id']);
            R::commit();
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }
}
