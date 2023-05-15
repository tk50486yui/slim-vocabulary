<?php

namespace app\Controllers;

use app\Models\ArticlesWords;
use app\Validators\Tables\ArticlesWordsValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

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
        $ArticlesWordsModel = new ArticlesWords();
        $ArticlesWordsValidator = new ArticlesWordsValidator();

        try {
            // 檢查 $data 格式
            if (!$ArticlesWordsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }
            // 再判斷所新增的關聯鍵是否已經存在 避免重複建立
            if ($ArticlesWordsModel->findByAssociatedIDs($data) != null) {
                return MsgH::Duplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $ArticlesWordsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);
    }

    /* 刪除關聯資料 ArticlesWords */
    public function delete($request, $response, $args)
    {
        $ArticlesWordsModel = new ArticlesWords();

        try {
            // 檢查 id 是否存在             
            if ($ArticlesWordsModel->find($args['id']) == null) {
                return MsgH::NotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $$ArticlesWordsModel->delete($args['id']);
            R::commit();
            // Transaction --結束--
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Deletion($response);
    }
}
