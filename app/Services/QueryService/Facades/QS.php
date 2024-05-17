<?php

namespace App\Services\QueryService\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Services\QueryService\Response call(string $pFuncName, array $pParam) 
 */
class QS extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'query_service';
  }
}
