<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\ArticlesWordsFactory;
use app\Models\ArticlesWords;

class ArticlesWordsController
{

    /* 查詢單一資料 ArticlesWords id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();

        try {
            $result = $ArticlesWordsModel->find($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 ArticlesWords */
    public function findAll($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();

        try {
            $result = $ArticlesWordsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 ArticlesWords */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesWordsFactory = new ArticlesWordsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();     
        $ArticlesWordsModel = new ArticlesWords();      

        try {
            $data = $ArticlesWordsFactory->createFactory($data, null);
            R::begin();
            $ArticlesWordsModel->add($data);
            R::commit();           
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    /* 刪除關聯資料 ArticlesWords */
    public function delete($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();

        try {                
            if ($ArticlesWordsModel->find($args['id']) == null) {
                return MsgH::NotFound($response);
            }         
            R::begin();
            $$ArticlesWordsModel->delete($args['id']);
            R::commit();
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Deletion($response);
    }
}
