<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\WordsTagsFactory;
use app\Models\WordsTags;

class WordsTagsController
{
    
    /* 新增單一資料 WordsTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsTagsModel = new WordsTags();
        $WordsTagsFactory = new WordsTagsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsTagsModel = new WordsTags();             

        try {
            $data = $WordsTagsFactory->createFactory($data, null);
            R::begin();
            $WordsTagsModel->add($data);
            R::commit();           
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);        
    }

    /* 刪除關聯資料 WordsTags */
    public function delete($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();

        try {
            // 檢查 id 是否存在                     
            if ($WordsTagsModel->find($args['id']) == null) {
                return MsgH::NotFound($response);
            }
            R::begin();
            $WordsTagsModel->delete($args['id']);
            R::commit();
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Deletion($response);
    }

    /* 查詢所有資料 WordsTags 關聯 Words Tags*/
    public function findAll($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();

        try {
            $result = $WordsTagsModel->findAll();  
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 以 tags id 查詢所有資料 WordsTags 關聯 Words Tags*/
    public function findByTagsID($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();

        try {
            $result = $WordsTagsModel->findByTagsID($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }
       
        return $response->withJson($result, 200);
    }
}
