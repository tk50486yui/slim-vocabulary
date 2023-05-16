<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Factories\ArticlesTagsFactory;
use app\Models\ArticlesTags;

class ArticlesTagsController
{   
    
    /* 新增單一資料 ArticlesTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesTagsFactory = new ArticlesTagsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $ArticlesTagsModel = new ArticlesTags();      

        try {
            $data = $ArticlesTagsFactory->createFactory($data, null);         
            R::begin();
            $ArticlesTagsModel->add($data);
            R::commit();               
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    /* 刪除關聯資料 ArticlesTags */
    public function delete($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();

        try {         
            if ($ArticlesTagsModel->find($args['id']) == null) {
                return MsgH::NotFound($response);
            }
            R::begin();
            $ArticlesTagsModel->delete($args['id']);
            R::commit();
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Deletion($response);
    }
}
