<?php

namespace libs\Responses;

use  libs\Responses\Msg;

class MsgHandler
{   
    /* 資料正常 */
    public static function Success($response)
    {
        $Msg = new Msg();
        $Msg->error = '';
        $Msg->result = true;
        return $response->withJson($Msg->toArray())->withStatus(200);
    }    

    /* 資料刪除完成 */
    public static function Deletion($response)
    {
        $Msg = new Msg();
        $Msg->error = '';
        $Msg->result = true;
        return $response->withJson($Msg->toArray())->withStatus(204);
    }

    /* 資料格式錯誤 ex 空值 非整數.. */
    public static function InvalidData($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Invalid data';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(400);
    }

    /* 外鍵格式或完整性錯誤 */
    public static function InvalidForeignKey($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Invalid foreign key';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(400);
    }

    /* Not Found */
    public static function NotFound($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Data not found';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(404);
    }

    /* 資料重複 */
    public static function Duplicate($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Duplicate data';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(409);
    }

    /* 資料處理失敗 */
    public static function DataProcessingFaild($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Data processing failed';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(422);
    }

    /* 伺服器錯誤 統一 */
    public static function ServerError($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Internal server error';
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(500);
    }

    /* 資料庫連接錯誤 */
    public static function ConnetFaild($response)
    {
        $Msg = new Msg();
        $Msg->error = 'Database connection failed';        
        $Msg->result = false;
        return $response->withJson($Msg->toArray())->withStatus(500);
    }
}
