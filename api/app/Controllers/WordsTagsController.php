<?php

namespace app\Controllers;

use app\Models\WordsTags;
use app\Msg;
use app\DatabaseManager;
use app\MsgHandler;
use Exception;

class WordsTagsController
{
    protected $WordsTagsModel;
    protected $MsgHandler;
    protected $Msg;
    /* 查詢單一資料 WordsTags id = ? */
    public function find($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $WordsTagsModel->find($args['id']);
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 查詢所有資料 WordsTags */
    public function findAll($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $WordsTagsModel->findAll();
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 新增單一資料 WordsTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();

        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            /* 新增 */
            $result = $WordsTagsModel->add($data);

            if ($result == true) {
                return $MsgHandler->handleSuccess($response, $Msg->msg);
            } else {
                return $MsgHandler->handleDataFaild($response, $Msg->msg);
            }
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }
    }

    /* 刪除關聯資料 WordsTags */
    public function delete($request, $response, $args)
    {        
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {
            
            /* 檢查 id 是否存在 */
            $check = $WordsTagsModel->find($args['id']);
            if ($check == false) {
                return $MsgHandler->handleNotFound($response, $Msg->msg);
            }

            $result = $WordsTagsModel->delete($args['id']);

            if ($result == true) {
                return $MsgHandler->handleSuccess($response, $Msg->msg);
            } else {
                return $MsgHandler->handleDataFaild($response, $Msg->msg);
            }
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }
    }
}
