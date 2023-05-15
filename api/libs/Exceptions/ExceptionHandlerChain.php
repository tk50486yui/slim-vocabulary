<?php 

namespace libs\Exceptions;

use Exception;
use libs\Exceptions\Interfaces\ExceptionHandlerInterface;

class ExceptionHandlerChain implements ExceptionHandlerInterface
{
    private $handlerMap;

    // 這裡儲存由HandlerFactory 建立的 new ExceptionHandlerChain($handlerMap)
    // $handlerMap 已經加入自定義例外並綁定完成
    public function __construct(ExceptionHandlerMap $handlerMap)
    {
        $this->handlerMap = $handlerMap;
    }

    // 這裡主要是判別進來的例外是屬於哪一種 $e是當下要處理的例外
    public function handle(Exception $e, $response)
    {
        // PHP內建方法 取得當下catch到的$e例外class名稱
        $class = get_class($e); 
        // 如果是 Exception 或其直屬子類別 則直接拋出
        if ($class === 'Exception' || get_parent_class($class) === 'Exception') {
            throw $e;
        }
        // 使用$handlerMap判斷是否為自定義例外
        $handler = $this->handlerMap->getHandler($class);     
        // 若是則直接執行
        if ($handler) {
            return $handler->handle($e, $response);
        }
        // 若找不到則丟出來 交給外層下一個catch 
        // 正常是交給Exception  catch(Exception $e){...}
        throw $e;
    }
}