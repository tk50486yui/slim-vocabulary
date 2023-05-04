<?php

namespace app\Controllers;

use app\Models\Categories;
use libs\Responses\MsgHandler;
use \RedBeanPHP\R as R;
use Exception;

class CategoriesController
{

    /* 查詢單一資料 Categories id = ? */
    public function find($request, $response, $args)
    {
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();

        try {

            $result = $CategoriesModel->find($args['id']);            
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);       
    }

    /* 查詢所有資料 Categories */
    public function findAll($request, $response, $args)
    {
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();

        try {

            $result = $CategoriesModel->findAll();
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);      
    }

    /* 新增單一資料 Categories */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查有沒有重複的名稱          
            if ($CategoriesModel->findByName($data['cate_name']) != null) {
                return $MsgHandler->handleDuplicate($response);
            }
            // Transaction --開始-- 
            R::begin();         
            $CategoriesModel->add($data);
            R::commit();    
            // Transaction --結束--  
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response);
    }

    /* 修改 edit 資料 Categories */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();

        try {
            // Transaction --開始-- 
            R::begin();         
            $CategoriesModel->edit($data, $args['id']);
            R::commit();    
            // Transaction --結束--  
        } catch (Exception $e) {
            // 資料處理失敗
            R::rollback();  
            return $MsgHandler->handleDataProcessingFaild($response);
        }

        return $MsgHandler->handleSuccess($response); 
    }

    /* JOIN查詢 Categories id 底下的 words */
    public function findWordsByID($request, $response, $args)
    {
        $CategoriesModel = new Categories();
        $MsgHandler = new MsgHandler();

        try {

            $result = $CategoriesModel->findWordsByID($args['id']);            
            
        } catch (Exception $e) {
            // 出錯統一用 Internal Server Error           
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);       
    }
}
