<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Servies\ArticlesServie;
use app\Factories\ArticlesFactory;
use app\Factories\ArticlesTagsFactory;
use app\Models\Articles;
use app\Models\ArticlesTags;

class ArticlesController
{

    /* 查詢單一資料 Articles id = ? */
    public function find($request, $response, $args)
    {
        $Articles = new Articles();
        $ArticlesTags = new ArticlesTags();

        try {
            $result = $Articles->find($args['id']);
            $result['articles_tags']['values'] = $ArticlesTags->findByArticlesID($args['id']);
            if(isset($result['articles_tags']['values']) && count($result['articles_tags']['values']) > 0){
                $result['articles_tags']['array'] = array();
                foreach($result['articles_tags']['values'] as $item){
                    array_push($result['articles_tags']['array'], (string)$item['ts_id']);                    
                }
            }   
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Articles */
    public function findAll($request, $response, $args)
    {
        $Articles = new Articles();      

        try {
            $result = $Articles->findAll();
            $i = 0;
            foreach($result as $item){                
                if($item['articles_tags'] != null){
                    $result[$i]['articles_tags'] = json_decode($item['articles_tags'], true);
                    if (isset($result[$i]['articles_tags']['values']) && count($result[$i]['articles_tags']['values']) > 0 ) {
                        $result[$i]['articles_tags']['array'] = array();
                        foreach($result[$i]['articles_tags']['values'] as $row){
                            array_push($result[$i]['articles_tags']['array'], (string)$row['ts_id']); 
                        }                      
                    }else{
                        $result[$i]['articles_tags']['array'] = array();
                    }                   
                }              
                $i++;  
            }
                    
        } catch (Exception $e) {    
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);   
    }

    /* 新增單一資料 Articles */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesServie = new ArticlesServie();  
        $ArticlesFactory = new ArticlesFactory();        
        $ArticlesTagsFactory = new ArticlesTagsFactory(); 
        $ExceptionHF = new ExceptionHandlerFactory();
        $Articles = new Articles();     
        $ArticlesTags = new ArticlesTags();

        try {
            $dataRow = $ArticlesFactory->createFactory($data, null);
            $ts_id_Array = $ArticlesServie->createServie($data);
            R::begin();            
            $id = $Articles->add($dataRow);            
            if($ts_id_Array){
                foreach($ts_id_Array as $item){
                    $new = array();
                    $new['arti_id'] = $id;
                    $new['ts_id'] = $item;
                    $new = $ArticlesTagsFactory->createFactory($new, null);                   
                    $ArticlesTags->add($new);
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

    /* 修改 edit 資料 Articles */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesServie = new ArticlesServie();
        $ArticlesFactory = new ArticlesFactory();
        $ArticlesTagsFactory = new ArticlesTagsFactory(); 
        $ExceptionHF = new ExceptionHandlerFactory();
        $Articles = new Articles();
        $ArticlesTags = new ArticlesTags();
        
        try {
            $dataRow = $ArticlesFactory->createFactory($data, $args['id']);
            $ts_id_Array = $ArticlesServie->createServie($data);           
            R::begin();
            $ArticlesTags->deleteByArtiID($args['id']);         
            if($ts_id_Array){                
                foreach($ts_id_Array as $item){    
                    $new = array();
                    $new['arti_id'] = $args['id'];
                    $new['ts_id'] = $item;
                    $new = $ArticlesTagsFactory->createFactory($new, null);               
                    $ArticlesTags->add($new);
                }                
            }           
            $Articles->edit($dataRow, $args['id']);
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
