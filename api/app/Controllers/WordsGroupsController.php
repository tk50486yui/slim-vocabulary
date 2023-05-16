<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\WordsGroupsFactory;
use app\Models\WordsGroups;

class WordsGroupsController
{

    /* 查詢單一資料 WordsGroups id = ? */
    public function find($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {
            $result = $WordsGroupsModel->find($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroups */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {
            $result = $WordsGroupsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增單一資料 WordsGroups */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsFactory = new WordsGroupsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsGroupsModel = new WordsGroups(); 

        try {
            $data = $WordsGroupsFactory->createFactory($data, null);
            R::begin();
            $WordsGroupsModel->add($data);
            R::commit();          
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    /* 修改 edit 資料 WordsGroups */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsFactory = new WordsGroupsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsGroupsModel = new WordsGroups();      

        try {
            $data = $WordsGroupsFactory->createFactory($data, $args['id']); 
            R::begin();
            $WordsGroupsModel->edit($data, $args['id']);
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
