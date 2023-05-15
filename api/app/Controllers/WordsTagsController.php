<?php

namespace app\Controllers;

use app\Models\WordsTags;
use app\Validators\Tables\WordsTagsValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

class WordsTagsController
{
    
    /* 新增單一資料 WordsTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsTagsModel = new WordsTags();
        $WordsTagsValidator = new WordsTagsValidator();             

        try {
            // 檢查 $data 格式
            if (!$WordsTagsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }
            // 再判斷所新增的關聯鍵是否已經存在 避免重複建立
            if ($WordsTagsModel->findByAssociatedIDs($data) != null) {
                return MsgH::Duplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsTagsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
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
            // Transaction --開始-- 
            R::begin();
            $WordsTagsModel->delete($args['id']);
            R::commit();
            // Transaction --結束-- 
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
