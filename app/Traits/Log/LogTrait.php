<?php

namespace App\Traits\Log;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait LogTrait
{
    /**
     * Logging untuk keperluan tracing.
     * 
     * @param string $pMessage log message
     */
    public function logTrace($pMessage)
    {
        Log::debug($pMessage);
    }

    /**
     * Logging terkait message stream transaksi.
     * 
     * @param  $pMessage log message
     */
    public function logStream($pMessage)
    {
        Log::info($pMessage);
    }

    /**
     * Logging terkait error sistem.
     * 
     * @param string    $pMessage   log message
     * @param Exception $pException original exception
     */
    public function logError($pMessage, $pException = null)
    {
        $tLogMessage = $pMessage;
        if (!is_null($pException)) {
            $tLogMessage .= "\n" .
                get_class($pException) . " : {$pException->getMessage()} ({$pException->getFile()}:{$pException->getLine()})\n" .
                "[stacktrace]\n";

            $tStackTraces = collect($pException->getTrace());
            $tStacksCount = $tStackTraces->count();
            $tStackTraces->each(function ($tItem, $tKey) use (&$tLogMessage, $tStacksCount) {
                $tFile = $tItem['file'] ?? '';
                $tLine = $tItem['line'] ?? '';
                $tLogMessage .= "#$tKey {$tFile}({$tLine}) : {$tItem['function']}\n";
                if ($tKey >= 20) {
                    $tStacksLeft = $tStacksCount - 20;
                    $tLogMessage .= "and $tStacksLeft more...";
                    return false;
                }
            });
        }
        Log::error($tLogMessage);
    }

    /**
     * Logging terkait database.
     * 
     * @param string $pMessage log message
     */
    public function logDB($pMessage)
    {
        Log::debug($pMessage);
    }
}
