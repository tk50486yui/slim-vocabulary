<?php

namespace libs\Responses;

use  libs\Responses\Msg;

class MsgHandler
{   
    /* 資料正常 */
    public static function handleSuccess($response)
    {
        $Msg = new Msg();
        $Msg->error = '';
        $Msg->result = true;
        return $response->withJson($Msg->toArray())->withStatus(200);
    }    

    /* 資料刪除完成 */
    public static function handleDeletion($response)
    {
        $Msg = new Msg();
        $Msg->error = '';
        $Msg->result = true;
        return $response->withJson($Msg->toArray())->withStatus(204);
    }

    /* 資料格式錯誤 ex 空值 非整數.. */
    public static function handleInvalidData($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Invalid data';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(400);
    }

    public static function handleInvalidForeignKey($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Invalid foreign key';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(400);
    }

    /* 查無該筆資料 */
    public static function handleNotFound($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Data not found';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(404);
    }

    /* 資料重複 */
    public static function handleDuplicate($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Duplicate data';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(409);
    }

    /* 資料處理失敗 */
    public static function handleDataProcessingFaild($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Data processing failed';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(422);
    }

    /* 伺服器錯誤 統一 */
    public static function handleServerError($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Internal server error';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(500);
    }

    /* 資料庫連接錯誤 */
    public static function handleConnetFaild($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Database connection failed';        
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(500);
    }
}
