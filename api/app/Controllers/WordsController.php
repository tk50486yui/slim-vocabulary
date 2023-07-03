<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\WordsFactory;
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
            $result['words_tags'] = $WordsTags->findByWordsID($args['id']);
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
        $WordsTags = new WordsTags();
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsModel = new Words();      

        try { 
            $dataRow = $WordsFactory->createFactory($data, null); 
            R::begin();
            $id = $WordsModel->add($dataRow);
            $dataWordsTags = $WordsServie->createServie($data, $id);
            if($dataWordsTags){
                foreach($dataWordsTags as $item){                   
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
        $WordsFactory = new WordsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsModel = new Words();

        try {
            $data = $WordsFactory->createFactory($data, $args['id']);            
            R::begin();
            $WordsModel->edit($data, $args['id']);
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
