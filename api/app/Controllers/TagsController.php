<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\TagsFactory;
use app\Models\Tags;

class TagsController
{

    /* 查詢單一資料 Tags id = ? */
    public function find($request, $response, $args)
    {
        $TagsModel = new Tags();

        try {
            $result = $TagsModel->find($args['id']);
        } catch (Exception $e) { 
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Tags */
    public function findAll($request, $response, $args)
    {
        $TagsModel = new Tags();

        try {
            $all = $TagsModel->findAll();
            // 建立樹狀結構資料
            $result = $TagsModel->buildTagsTree($all);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);        
    }

    /* 新增單一資料 Tags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();           
        $TagsFactory = new TagsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $TagsModel = new Tags();  
        
        try { 
            $data = $TagsFactory->createFactory($data, null);
            R::begin();
            $TagsModel->add($data);
            R::commit();
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    /* 修改 edit 資料 Tags */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $TagsFactory = new TagsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $TagsModel = new Tags();

        try {
            $data = $TagsFactory->createFactory($data, $args['id']);
            R::begin();
            $TagsModel->edit($data, $args['id']);
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
