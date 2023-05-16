<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\ArticlesFactory;
use app\Models\Articles;

class ArticlesController
{

    /* 查詢單一資料 Articles id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesModel = new Articles();

        try {
            $result = $ArticlesModel->find($args['id']);            
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Articles */
    public function findAll($request, $response, $args)
    {
        $ArticlesModel = new Articles();

        try {
            $result = $ArticlesModel->findAll();            
        } catch (Exception $e) {    
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);   
    }

    /* 新增單一資料 Articles */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesFactory = new ArticlesFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $ArticlesModel = new Articles();     

        try {
            $data = $ArticlesFactory->createFactory($data, null);
            R::begin();
            $ArticlesModel->add($data);
            R::commit();            
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);        
    }

    /* 修改 edit 資料 Articles */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesFactory = new ArticlesFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $ArticlesModel = new Articles();  
        
        try {
            $data = $ArticlesFactory->createFactory($data, $args['id']);
            R::begin();
            $ArticlesModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束--  
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }
}
