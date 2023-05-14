<?php

namespace app\Controllers;

use app\Models\Categories;
use app\Validators\tables\CategoriesValidator;
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

            $all = $CategoriesModel->findAll();
            // 建立樹狀結構資料
            $result = $CategoriesModel->buildCategoriesTree($all);

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
        $CategoriesValidator = new CategoriesValidator();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$CategoriesValidator->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
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
        $CategoriesValidator = new CategoriesValidator();
        $MsgHandler = new MsgHandler();

        try {
            // 檢查 $data 格式
            if (!$CategoriesValidator->validate($data)) {
                return $MsgHandler->handleInvalidData($response);
            }
            // 檢查 cate_parent_id
            $all = $CategoriesModel->findAll();
            // 建立樹狀結構資料
            $tree = $CategoriesModel->buildCategoriesTree($all);
            // 檢查所新增之 cate_parent_id 是否為自己的子節點 有值才做
            if($data['cate_parent_id'] != null || $data['cate_parent_id'] != ''){
                if($CategoriesValidator->validateParent($tree, $args['id'], $data['cate_parent_id'])){
                    return $MsgHandler->handleInvalidData($response);
                }
            }           
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