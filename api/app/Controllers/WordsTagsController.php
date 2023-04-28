<?php

namespace app\Controllers;

use app\Models\WordsTags;
use app\Models\Words;
use app\Models\Tags;
use libs\Responses\MsgHandler;
use Exception;

class WordsTagsController
{

    /* 查詢單一資料 WordsTags id = ? */
    public function find($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();             

        try {

            $result = $WordsTagsModel->find($args['id']);

        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }

    /* 查詢所有資料 WordsTags */
    public function findAll($request, $response, $args)
    {
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();          

        try {

            $result = $WordsTagsModel->findAll();

        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response);
        }

        return $response->withJson($result, 200);
    }
    
    /* 新增單一資料 WordsTags */
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsTagsModel = new WordsTags();
        $WordsModel = new Words();
        $TagsModel = new Tags();
        $MsgHandler = new MsgHandler();   

        try {

            /* 新增 */
            $result = $WordsTagsModel->add($data);

            if ($result == true) {
                return $MsgHandler->handleSuccess($response);
            } else {
                return $MsgHandler->handleDataFaild($response);
            }
        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response);
        }
    }

    /* 刪除關聯資料 WordsTags */
    public function delete($request, $response, $args)
    {        
        $WordsTagsModel = new WordsTags();
        $MsgHandler = new MsgHandler();         

        try {
            
            /* 檢查 id 是否存在 */
            $check = $WordsTagsModel->find($args['id']);
            if ($check == false) {
                return $MsgHandler->handleNotFound($response);
            }

            $result = $WordsTagsModel->delete($args['id']);

            if ($result == true) {
                return $MsgHandler->handleSuccess($response);
            } else {
                return $MsgHandler->handleDataFaild($response);
            }

        } catch (Exception $e) {
            /* 出錯統一用 Internal Server Error */
            return $MsgHandler->handleServerError($response);
        }
    }
}
