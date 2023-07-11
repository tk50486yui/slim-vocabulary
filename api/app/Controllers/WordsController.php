<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\WordsFactory;
use app\Factories\WordsTagsFactory;
use app\Servies\WordsServie;
use app\Models\Words;
use app\Models\WordsTags;

class WordsController
{

    /* 查詢單一資料 words id = ? */
    public function find($request, $response, $args)
    {
        $WordsModel = new Words();
        $WordsTags = new WordsTags();
        try {
            $result = $WordsModel->find($args['id']);
            $result['words_tags']['values'] = $WordsTags->findByWordsID($args['id']);
            if(isset($result['words_tags']['values']) && count($result['words_tags']['values']) > 0){
                $result['words_tags']['array'] = array();
                foreach($result['words_tags']['values'] as $item){
                    array_push($result['words_tags']['array'], (string)$item['ts_id']);                    
                }
            }
          
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
            $i = 0;
            foreach($result as $item){                
                if($item['words_tags'] != null){
                    $result[$i]['words_tags'] = json_decode($item['words_tags'], true);
                    if (isset($result[$i]['words_tags']['values']) && count($result[$i]['words_tags']['values']) > 0 ) {
                        $result[$i]['words_tags']['array'] = array();
                        foreach($result[$i]['words_tags']['values'] as $row){
                            array_push($result[$i]['words_tags']['array'], (string)$row['ts_id']); 
                        }                      
                    }else{
                        $result[$i]['words_tags']['array'] = array();
                    }                   
                }              
                $i++;  
            } 

        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增 words 綜合式新增 包含(WordsTags) */
    public function add($request, $response, $args)
    {       
        $data = $request->getParsedBody();
        $WordsServie = new WordsServie();
        $WordsFactory = new WordsFactory();
        $WordsTagsFactory = new WordsTagsFactory();
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsModel = new Words();        
        $WordsTags = new WordsTags();

        try { 
            $dataRow = $WordsFactory->createFactory($data, null); 
            $array_ts_id = $WordsServie->createServie($data);
            R::begin();
            $id = $WordsModel->add($dataRow);         
            if($array_ts_id){
                foreach($array_ts_id as $item){   
                    $new = array();
                    $new['ws_id'] = $id;
                    $new['ts_id'] = $item;
                    $new = $WordsTagsFactory->createFactory($new, null);                   
                    $WordsTags->add($item);
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

    /* 修改 edit 資料 words */
    public function edit($request, $response, $args)
    {      
        $data = $request->getParsedBody();
        $WordsServie = new WordsServie();
        $WordsFactory = new WordsFactory();  
        $WordsTagsFactory = new WordsTagsFactory();
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsModel = new Words();
        $WordsTags = new WordsTags();

        try {
            $dataRow = $WordsFactory->createFactory($data, $args['id']);
            $array_ts_id = $WordsServie->createServie($data);
            R::begin();
            $WordsTags->deleteByWsID($args['id']);
            if($array_ts_id){                
                foreach($array_ts_id as $item){       
                    $new = array();
                    $new['ws_id'] = $args['id'];
                    $new['ts_id'] = $item;
                    $new = $WordsTagsFactory->createFactory($new, null);                    
                    $WordsTags->add($new);
                }                
            }            
            $WordsModel->edit($dataRow, $args['id']);
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
