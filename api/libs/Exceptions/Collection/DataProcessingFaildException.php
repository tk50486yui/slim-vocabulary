<?php

namespace libs\Exceptions\Collection;

use Exception;
use libs\Exceptions\BaseExceptionCollection;
use libs\Exceptions\Interfaces\ExceptionHandlerInterface;
use libs\Responses\MsgHandler as MsgH;

class DataProcessingFaildException extends BaseExceptionCollection implements ExceptionHandlerInterface
{
   public function handle(Exception $e, $response)
   {
      return MsgH::DataProcessingFaild($response);
   }
}
