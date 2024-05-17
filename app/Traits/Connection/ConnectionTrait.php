<?php

namespace App\Traits\Connection;

use App\Exceptions\AppException;
use App\Services\ResponseCode;
use App\Traits\Log\LogTrait;
use Illuminate\Support\Facades\Log;

trait ConnectionTrait
{
    use LogTrait;

    /**
     * Send message via socket.
     *
     * @param  string   $pHost      target host
     * @param  int      $pPort      target port
     * @param  int      $pTimeout   timeout
     * @param  string   $pMessage   request message
     * @return string               response stream
     * @throws App\Exceptions\AppException if cannot connect to destination host
     */

    private function traceLog($pMessage)
    {
        Log::debug($pMessage);
        Log::channel('daily')->debug($pMessage);
    }

    private function sendAPI($pUrl, $pData)
    {
        $tStringData = json_encode($pData);
        $this->traceLog("API Request to {$pUrl} : {$tStringData}");

        $tMethod = 'POST';
        $requestBody = str_replace(array(" ", "\n", "\t", "\r"), array("", "", "", ""), $tStringData);
        $tCurl = curl_init($pUrl);
        curl_setopt($tCurl, CURLOPT_CUSTOMREQUEST, $tMethod);
        curl_setopt($tCurl, CURLOPT_POSTFIELDS, $tStringData);
        curl_setopt($tCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $tCurl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($tStringData),
            )
        );
        sleep(0.5);
        $tResult = curl_exec($tCurl);
        curl_close($tCurl);

        $this->traceLog("API Response from {$pUrl} : {$tResult}");

        return json_decode($tResult, true);
    }

    public function sendSocket($pHost, $pPort, $pTimeout, $pMessage)
    {
        $this->logStream('[' . __METHOD__ . "] Send request to $pHost:$pPort with timeout $pTimeout : $pMessage");
        $tResp = '';
        $tSocketConn = fsockopen($pHost, $pPort, $tErrorCode, $tErrorMessage, $pTimeout);
        if (!$tSocketConn) {
            $this->logError('[' . __METHOD__ . "] Failed to open socket to $pHost:$pPort with error code $tErrorCode and message $tErrorMessage");
        } else {
            fwrite($tSocketConn, $pMessage, strlen($pMessage));
            fwrite($tSocketConn, chr(-1));
            @stream_set_timeout($tSocketConn, $pTimeout);

            $tIsDone = false;
            while ((!feof($tSocketConn)) && !$tIsDone) {
                $info = @stream_get_meta_data($tSocketConn);
                if ($info['timed_out']) {
                    $tIsDone = true;
                    $this->logError('[' . __METHOD__ . "] Socket connection to $pHost:$pPort is timed out");
                    break;
                }

                $tChar = fread($tSocketConn, 1);
                if ($tChar != chr(-1)) {
                    $tResp .= $tChar;
                } else {
                    $tIsDone = true;
                }
            }

            fclose($tSocketConn);
            $this->logStream('[' . __METHOD__ . "] Got response from $pHost:$pPort : $tResp");
        }

        return $tResp;
    }
}
