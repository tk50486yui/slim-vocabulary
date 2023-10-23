<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Services\CategoriesService;
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
            if($data['cate_parent_id'] != null){
                $parent = $CategoriesModel->find($data['cate_parent_id']);
                $data['cate_level'] = $parent['cate_level'] + 1;
                $children = $CategoriesModel->findMaxOrderByParent($data['cate_parent_id']);
                if($children['sibling_count'] == 0){
                    $data['cate_order'] = 0;
                }else{
                    $data['cate_order'] = $children['max_cate_order'] + 1;                 
                }                
            }else{
                $sibling = $CategoriesModel->findOrderInFirstLevel();
                if($sibling && $sibling != null){
                    $data['cate_order'] = $sibling['max_cate_order'] + 1;                  
                }                
            }
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

    /* 修改 edit 資料 Categories  不包含層級順序 */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $CategoriesFactory = new CategoriesFactory();
        $ExceptionHF = new ExceptionHandlerFactory();
        $CategoriesModel = new Categories();

        try {
            $data = $CategoriesFactory->createFactory($data, $args['id']);           
            R::begin();           
            $row = $CategoriesModel->find($args['id']);        
            if($data['cate_parent_id'] != $row['cate_parent_id']){
                if($data['cate_parent_id'] == null){
                    $sibling = $CategoriesModel->findOrderInFirstLevel();
                    if($sibling && $sibling != null){
                        $data['cate_order'] = $sibling['max_cate_order'] + 1;                  
                    } 
                }else{
                    $children = $CategoriesModel->findMaxOrderByParent($data['cate_parent_id']);
                    if($children['sibling_count'] == 0){
                        $data['cate_order'] = 0;
                    }else{
                        $data['cate_order'] = $children['max_cate_order'] + 1;                 
                    }
                }               
            }
            $CategoriesModel->edit($data, $args['id']);
            $CategoriesModel->editOrder($data['cate_order'], $args['id']);           
            R::commit();       
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response); 
    }

    /* 修改順序 */
    public function editOrder($request, $response, $args)
    {
        $data = $request->getParsedBody();        
        $CategoriesService = new CategoriesService();
        $ExceptionHF = new ExceptionHandlerFactory();
        $CategoriesModel = new Categories();

        try {          
            $NewData = $CategoriesService->createService($data);           
            R::begin();         
            foreach($NewData as $item){
                if(is_numeric($item['id']) && is_numeric($item['cate_order'])){
                    $CategoriesModel->editOrder((int)$item['cate_order'], (int)$item['id']);                   
                }                
            }           
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

     /*  查詢近期新增  */
     public function findRecent($request, $response, $args)
     {
         $CategoriesModel = new Categories();
 
         try {
             $result = $CategoriesModel->findRecent();     
         } catch (Exception $e) {
             return MsgH::ServerError($response);
         }
 
         return $response->withJson($result, 200);        
     }
    
}