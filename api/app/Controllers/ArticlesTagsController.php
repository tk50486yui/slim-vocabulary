<?php

namespace app\Controllers;

use app\Models\ArticlesTags;
use app\Validators\Tables\ArticlesTagsValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

class ArticlesTagsController
{

    /* 查詢單一資料 ArticlesTags id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();

        try {
            $result = $ArticlesTagsModel->find($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 ArticlesTags */
    public function findAll($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();

        try {
            $result = $ArticlesTagsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增單一資料 ArticlesTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesTagsModel = new ArticlesTags();
        $ArticlesTagsValidator = new ArticlesTagsValidator();

        try {
            // 檢查 $data 格式
            if (!$ArticlesTagsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }
            // 再判斷所新增的關聯鍵是否已經存在 避免重複建立
            if ($ArticlesTagsModel->findByAssociatedIDs($data) != null) {
                return MsgH::Duplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesTagsModel->add($data);
            R::commit();
            // Transaction --結束--              
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);
    }

    /* 刪除關聯資料 ArticlesTags */
    public function delete($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();

        try {
            // 檢查 id 是否存在        
            if ($ArticlesTagsModel->find($args['id']) == null) {
                return MsgH::NotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesTagsModel->delete($args['id']);
            R::commit();
            // Transaction --結束--
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Deletion($response);
    }
}
