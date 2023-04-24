<?php
namespace app;

class MsgHandler
{
     /* 資料正常 */
     function handleSuccess($response, $msg) {
        $response = $response->withStatus(200);
        $msg['error']  = '';
        $msg['success']  = true;
        return $response->withJson($msg);
    }

    /* 資料重複 */ 
    function handleDuplicate($response, $msg) {
        $response = $response->withStatus(409);
        $msg['error']  = 'Duplicate data';
        $msg['success']  = false;
        return $response->withJson($msg);
    }

     /* 資料處理失敗 */ 
     function handleDataFaild($response, $msg) {
        $response = $response->withStatus(422);
        $msg['error']  = 'Data processing failed';
        $msg['success']  = false;
        return $response->withJson($msg);
    }

    /* 伺服器錯誤 統一 */ 
    function handleServerError($response, $msg) {
        $response = $response->withStatus(500);
        $msg['error']  = 'Internal server error';
        $msg['success']  = false;
        return $response->withJson($msg);
    }
    /* 資料庫連接錯誤 */
    function handleConnetFaild($response, $msg) {
        $response = $response->withStatus(500);
        $msg['error']  = 'Database connection failed';
        $msg['success']  = false;
        return $response->withJson($msg);
    }
}