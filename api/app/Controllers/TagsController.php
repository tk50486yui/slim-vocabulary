<?php

namespace app\Controllers;

use app\Models\Tags;
use app\Validators\Tables\TagsValidator;
use libs\Responses\MsgHandler as MsgH;
use \RedBeanPHP\R as R;
use Exception;

class TagsController
{

    /* 查詢單一資料 Tags id = ? */
    public function find($request, $response, $args)
    {
        $TagsModel = new Tags();

        try {
            $result = $TagsModel->find($args['id']);
        } catch (Exception $e) { 
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 Tags */
    public function findAll($request, $response, $args)
    {
        $TagsModel = new Tags();

        try {
            $result = $TagsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);        
    }

    /* 新增單一資料 Tags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $TagsModel = new Tags();     
        $TagsValidator = new TagsValidator();
        
        try {            
            // 檢查 $data 格式
            if (!$TagsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }
            // 檢查有沒有重複的標籤名稱      
            if ($TagsModel->findByName($data['ts_name']) != null) {
                return MsgH::Duplicate($response);
            }
            // Transaction --開始-- 
            R::begin();
            $TagsModel->add($data);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);
    }

    /* 修改 edit 資料 Tags */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $TagsModel = new Tags();
        $TagsValidator = new TagsValidator();

        try {
            // 檢查 $data 格式
            if (!$TagsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }           
            // Transaction --開始-- 
            R::begin();
            $TagsModel->edit($data, $args['id']);
            R::commit();
            // Transaction --結束-- 
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);
    }
}
