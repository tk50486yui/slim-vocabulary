<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use app\Validators\Tables\WordsGroupsValidator;
use app\Models\WordsGroups;

class WordsGroupsController
{

    /* 查詢單一資料 WordsGroups id = ? */
    public function find($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {
            $result = $WordsGroupsModel->find($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsGroups */
    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {
            $result = $WordsGroupsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 新增單一資料 WordsGroups */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsValidator = new WordsGroupsValidator();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }        
            R::begin();
            $WordsGroupsModel->add($data);
            R::commit();          
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);
    }

    /* 修改 edit 資料 WordsGroups */
    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsValidator = new WordsGroupsValidator();

        try {
            // 檢查 $data 格式
            if (!$WordsGroupsValidator->validate($data)) {
                return MsgH::InvalidData($response);
            }       
            R::begin();
            $WordsGroupsModel->edit($data, $args['id']);
            R::commit();          
        } catch (Exception $e) {
            R::rollback();
            return MsgH::DataProcessingFaild($response);
        }

        return MsgH::Success($response);
    }
}
