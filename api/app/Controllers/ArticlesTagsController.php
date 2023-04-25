<?php

namespace app\Controllers;

use app\Models\ArticlesTags;
use app\Msg;
use app\DatabaseManager;
use app\MsgHandler;
use Exception;

class ArticlesTagsController
{
    protected $ArticlesTagsModel;
    protected $MsgHandler;
    protected $Msg;
    /* 查詢單一資料 ArticlesTags id = ? */
    public function find($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $ArticlesTagsModel->find($args['id']);
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 查詢所有資料 ArticlesTags */
    public function findAll($request, $response, $args)
    {
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            $result = $ArticlesTagsModel->findAll();
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response, $Msg->msg);
        }

        return $response->withJson($result, 200);
    }
    /* 新增單一資料 ArticlesTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();

        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            /* 新增 */
            $result = $ArticlesTagsModel->add($data);

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

    /* 刪除關聯資料 ArticlesTags */
    public function delete($request, $response, $args)
    {       
        $ArticlesTagsModel = new ArticlesTags();
        $MsgHandler = new MsgHandler();
        $Msg = new Msg();
        if (!DatabaseManager::checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }

        try {

            /* 檢查 id 是否存在 */
            $check = $ArticlesTagsModel->find($args['id']);
            if ($check == false) {
                return $MsgHandler->handleNotFound($response, $Msg->msg);
            }

            $result = $ArticlesTagsModel->delete($args['id']);

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
