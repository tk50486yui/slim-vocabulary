<?php

namespace libs\Responses;

use  libs\Responses\Msg;

class MsgHandler
{
    /*  $this->msg */
    private $msg;

    public function __construct()
    {
        $Msg = new Msg(); // 物件 
        $this->msg = $Msg->msg; // Msg 的 $msg[]
    }

    /* 資料正常 */
    function handleSuccess($response)
    {        
        $this->msg['error']  = '';
        $this->msg['success']  = true;
        return $response->withJson($this->msg)->withStatus(200);
    }

    /* 查無該筆資料 */
    function handleDataNotNull($response)
    {        
        $this->msg['error']  = 'Data not null';
        $this->msg['success']  = false;
        return $response->withJson($this->msg)->withStatus(400);
    }

    /* 查無該筆資料 */
    function handleNotFound($response)
    {        
        $this->msg['error']  = 'Data not found';
        $this->msg['success']  = false;
        return $response->withJson($this->msg)->withStatus(404);
    }

    /* 資料重複 */
    function handleDuplicate($response)
    {     
        $this->msg['error']  = 'Duplicate data';
        $this->msg['success']  = false;
        return $response->withJson($this->msg)->withStatus(409);
    }

    /* 資料處理失敗 */
    function handleDataFaild($response)
    {     
        $this->msg['error']  = 'Data processing failed';
        $this->msg['success']  = false;
        return $response->withJson($this->msg)->withStatus(422);
    }

    /* 伺服器錯誤 統一 */
    function handleServerError($response)
    {        
        $this->msg['error']  = 'Internal server error';
        $this->msg['success']  = false;
        return $response->withJson($this->msg)->withStatus(500);
    }

    /* 資料庫連接錯誤 */
    function handleConnetFaild($response)
    {        
        $this->msg['error']  = 'Database connection failed';
        $this->msg['success']  = false;
        return $response->withJson($this->msg)->withStatus(500);
    }
}
