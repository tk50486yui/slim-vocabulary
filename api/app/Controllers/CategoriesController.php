<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\CategoriesFactory;
use app\Models\Categories;

class CategoriesController
{

    /* 查詢單一資料 Categories id = ? */
    public function find($request, $response, $args)
    {
        $CategoriesModel = new Categories();

        try {
            $result = $CategoriesModel->find($args['id']); 
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);       
    }

    /* 查詢所有資料 Categories */
    public function findAll($request, $response, $args)
    {
        $CategoriesModel = new Categories();

        try {
            $all = $CategoriesModel->findAll();
            // 建立樹狀結構資料
            $result = $CategoriesModel->buildCategoriesTree($all);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);      
    }

    /* 新增單一資料 Categories */
    public function add($request, $response, $args)
    {       
        $data = $request->getParsedBody();       
        $CategoriesFactory = new CategoriesFactory();
        $ExceptionHF = new ExceptionHandlerFactory();
        $CategoriesModel = new Categories();
     
        try {
            $data = $CategoriesFactory->createFactory($data, null); 
            R::begin();         
            $CategoriesModel->add($data);
            R::commit();    
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    /* 修改 edit 資料 Categories */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $CategoriesFactory = new CategoriesFactory();
        $ExceptionHF = new ExceptionHandlerFactory();
        $CategoriesModel = new Categories();

        try {
            $data = $CategoriesFactory->createFactory($data, $args['id']);           
            R::begin();         
            $CategoriesModel->edit($data, $args['id']);
            R::commit();       
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response); 
    }

    /* JOIN查詢 Categories id 底下的 words */
    public function findWordsByID($request, $response, $args)
    {
        $CategoriesModel = new Categories();

        try {
            $result = $CategoriesModel->findWordsByID($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);       
    }
    
}