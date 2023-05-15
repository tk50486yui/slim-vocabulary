<?php

namespace app\Controllers;

use app\Models\WordsGroupsDetails;
use app\Validators\Tables\WordsGroupsDetailsValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

class WordsGroupsDetailsController
{
    
    /* 查詢單一資料 WordsGroupsDetails id = ? */
    public function find($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();

        try {
            $result = $WordsGroupsDetailsModel->find($args['id']);
        } catch (Exception $e) {        
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroupsDetails */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();

        try {
            $result = $WordsGroupsDetailsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);        
    }

    /* 新增單一資料 WordsGroupsDetails */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $WordsGroupsDetailsValidator = new WordsGroupsDetailsValidator();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsDetailsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }
            // 再判斷所新增的關聯鍵是否已經存在 避免重複建立
            if ($WordsGroupsDetailsModel->findByAssociatedIDs($data) != null) {
                return MsgH::Duplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsDetailsModel->add($data);
            R::commit();
            // Transaction --結束--            
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);       
    }

    /* 修改資料 WordsGroupsDetails */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsDetailsModel = new WordsGroupsDetails();
        $WordsGroupsDetailsValidator = new WordsGroupsDetailsValidator();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsDetailsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsDetailsModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束--            
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);       
    }

    /* 刪除關聯資料 WordsGroupsDetails */
    public function delete($request, $response, $args)
    {
        $WordsGroupsDetailsModel = new WordsGroupsDetails();

        try {
            // 檢查 id 是否存在          
            if ($WordsGroupsDetailsModel->find($args['id']) == null) {
                return MsgH::NotFound($response);
            }
            // Transaction --開始-- 
            R::begin();
            $WordsGroupsDetailsModel->delete($args['id']);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) { 
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Deletion($response);       
    }
}
