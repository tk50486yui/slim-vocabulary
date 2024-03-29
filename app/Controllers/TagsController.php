<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Services\TagsService;
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

    /* 查詢所有資料 Tags --回傳樹狀結構-- */
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
            if($data['ts_parent_id'] != null){
                $parent = $TagsModel->find($data['ts_parent_id']);
                $data['ts_level'] = $parent['ts_level'] + 1;
                $children = $TagsModel->findMaxOrderByParent($data['ts_parent_id']);
                if($children['sibling_count'] == 0){
                    $data['ts_order'] = 0;
                }else{
                    $data['ts_order'] = $children['max_ts_order'] + 1;                 
                }                
            }else{
                $sibling = $TagsModel->findOrderInFirstLevel();
                if($sibling && $sibling != null){
                    $data['ts_order'] = $sibling['max_ts_order'] + 1;                  
                }                
            }
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
            $row = $TagsModel->find($args['id']);        
            if($data['ts_parent_id'] != $row['ts_parent_id']){
                if($data['ts_parent_id'] == null){
                    $sibling = $TagsModel->findOrderInFirstLevel();
                    if($sibling && $sibling != null){
                        $data['ts_order'] = $sibling['max_ts_order'] + 1;                  
                    }  
                }else{
                    $children = $TagsModel->findMaxOrderByParent($data['ts_parent_id']);
                    if($children['sibling_count'] == 0){
                        $data['ts_order'] = 0;
                    }else{
                        $data['ts_order'] = $children['max_ts_order'] + 1;                 
                    } 
                }
            }           
            R::begin();
            $TagsModel->edit($data, $args['id']);
            $TagsModel->editOrder($data['ts_order'], $args['id']);
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
         $TagsService = new TagsService();   
         $ExceptionHF = new ExceptionHandlerFactory();             
         $TagsModel = new Tags();
 
         try {          
             $NewData = $TagsService->createService($data);           
             R::begin();         
             foreach($NewData as $item){
                 if(is_numeric($item['id']) && is_numeric($item['ts_order'])){
                    $TagsModel->editOrder((int)$item['ts_order'], (int)$item['id']);                          
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

    /*  查詢近期新增  */
    public function findRecent($request, $response, $args)
    {
        $TagsModel = new Tags();

        try {
            $result = $TagsModel->findRecent();     
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);        
    }

    /*  查詢常用標籤  */
    public function findPopular($request, $response, $args)
    {
        $TagsModel = new Tags();

        try {
            $result = $TagsModel->findAll();       
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);        
    }
}
