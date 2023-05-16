<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use app\Validators\Tables\WordsGroupsDetailsValidator;
use app\Models\WordsGroupsDetails;

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

        try {          
            R::begin();
            $WordsGroupsDetailsModel->add($data);
            R::commit();          
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
            R::begin();
            $WordsGroupsDetailsModel->edit($data, $args['id']);
            R::commit();
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
