<?php

namespace App\Services\QueryService;


use App\Traits\Connection\ConnectionTrait;
use App\Traits\Connection\Services_JSON;
use App\Traits\Connection\Crypt_AES;
use Illuminate\Support\Facades\Log;

class QueryService
{
    use ConnectionTrait;

    private  $mHost;
    private  $mPort;
    private  $mPAN;
    private  $mTimeout;

    private  $mHost_json;
    private  $mPort_json;
    private  $mPorto;

    private $DATA_PATH = "VIOSS/inc/svc/svcDbConn.php";
    private $DATA_GROUP = null;
    private $DATA_UID;

    public function __construct()
    {
        $this->mHost = config('queryservice.host');
        $this->mPort = config('queryservice.port');
        $this->mPAN = config('queryservice.pan');
        $this->mTimeout = config('queryservice.timeout');

        //$this->mHost_json = config('jsonservice.hostjson');
        $this->mPort_json = config('jsonservice.portjson');
        $this->mPorto = config('jsonservice.port_to');
    }

    /**
     * @param string $pFuncName query function name
     * @param array $pParams query parameter
     * @return \App\Services\QueryService\Response response object
     * @throws \App\Exceptions\ConnectionException if cannot connect to query service
     */
    public function call($pFuncName, $pParams = [])
    {

        $taRequest['f'] = $pFuncName;
        $taRequest['i'] = empty($pParams) ? json_decode('{}') : $pParams;
        $taRequest['PAN'] = $this->mPAN;
        $aRequest["UID"] = "uidVsi";
        $tsRequest = json_encode($taRequest);

        $this->logDB("QS Request to {$this->mHost}:{$this->mPort} with timeout {$this->mTimeout} : $tsRequest");
        $tsResp = $this->sendSocket($this->mHost, $this->mPort, $this->mTimeout, $tsRequest);

        $this->logDB("QS Response from {$this->mHost}:{$this->mPort} : $tsResp");

        $toResp = new Response($tsResp);

        return $toResp;
    }



    // Disini fungsi-fungsi yang dibutuhkan untuk connect ke backend  
    public function JsonExec(&$arResult, /* $fname, */ $arData)
    {
        $arResult = null;
        $bOk = false;
        foreach ($arData as $key => $value) {
            if (is_array($value)) {
                $send[$key] = array($value);
            } else {
                $send[$key] = addslashes($value);
            }
        }

        $data = $this->callRemoteFunction(/* $fname, */$send);
        $bOk = true;
        $arResult = $data;
        return $bOk;
    }

    public function NetmanExec(&$arResult, /* $fname, */ $arData)
    {
        $arResult = null;
        $bOk = false;
        foreach ($arData as $key => $value) {
            if (is_array($value)) {
                $send[$key] = array($value);
            } else {
                $send[$key] = addslashes($value);
            }
        }

        $data = $this->callRemoteFunction(/* $fname, */$send);
        $bOk = true;

        $arResult = $data;

        return $bOk;
    }


    public function callRemoteFunction($aRole/* ,$aParam */)
    {
        $sResp = "";
        /* === SET REQUEST TO JSON === */
        $obJson = new Services_JSON(SERVICES_JSON_SUPPRESS_ERRORS);
        //$jParam = $obJson->encode($aParam);
        foreach ($aRole as $key => $value) {
            if (is_array($value)) {
                $jParam = $obJson->encode($value);
                $aRequest[$key] = $jParam;
                $aRequest[$key] = str_replace('[{', '{', $aRequest[$key]);
                $aRequest[$key] = str_replace('}]', '}', $aRequest[$key]);
            } else {
                $aRequest[$key] = $value;
            }
        }

        $sRequest = $obJson->encode($aRequest);
        $sRequest = str_replace('\\', '', $sRequest);
        $sRequest = str_replace('"{', '{', $sRequest);
        $sRequest = str_replace('}"', '}', $sRequest);


        //$ect = $sRequest;
        $ect = $this->encryptData("JSON", $sRequest);

        // Logging request
        Log::channel('request')->info("[" . strftime("%Y%m%d%H%M%S", time()) . "][REQUEST][" . $this->mHost . ":" . $this->mPort_json . "]  : " . $sRequest);


        /* === CHECk CONNECTION TYPE === */
        $timeout = $this->GetRemoteResponse($this->mHost, $this->mPort_json, $this->mTimeout, $ect, $sResp);

        if ($timeout) {
            $aResult = $this->decryptData("JSON", $sResp);
            $sResponse = $obJson->decode($aResult);
            // $sResponse->RC;
            if (is_object($sResponse) && property_exists($sResponse, 'MP')) {
                $sResponse->MP = $obJson->decode($sResponse->MP);
            }
        }

        Log::channel('response')->info("[" . strftime("%Y%m%d%H%M%S", time()) . "][RESPONSE][" . $this->mHost . ":" . $this->mPort_json . "] : " .   $aResult);
        return $sResponse;
    }


    function GetRemoteResponse($address, $port, $timeout, $out, &$sResp)
    {
        $s = '';
        $bTimeout = 0;
        // /$out = json_encode($out);
        $fp = fsockopen($address, $port, $errno, $errstr, $timeout);
        if (!$fp) {
            $s = $errstr . " (" . $errno . ")";
        } else {
            $n = fwrite($fp, $out, strlen($out));
            $n = fwrite($fp, chr(-1));
            @stream_set_timeout($fp, $timeout);

            $c = '';
            $bDone = false;
            $bHead = false;
            $lenCount = 0;
            $i = 0;
            while ((!feof($fp)) && ($bTimeout == 0) && (!$bDone)) {
                $info = @stream_get_meta_data($fp);
                if ($info['timed_out']) {
                    $bTimeout = 1;
                }

                if ($bTimeout == 0) {
                    $c = fread($fp, 1);
                    if ($c != chr(-1)) {
                        $s .= $c;
                    } else {
                        $bDone = true;
                    }
                } // end of !$bTimeout
            }
            $bTimeout = 1;
            fclose($fp);
        }
        $sResp = $s;
        return $bTimeout;
    }

    function encryptData($arParam, $str)
    {

        $status = $arParam[0];
        $type = $arParam[1];
        $mode = $arParam[2];
        $key = $arParam[3];
        if ($status == TRUE) {
            switch ($type) {
                case "AES":
                    $output = $this->encryptAES($mode, $key, $str);
                    break;
                default:
                    $output = $str;
                    break;
            }
        } else {
            $output = base64_encode($str);
        }
        return $output;
    }

    function decryptData($arParam, $str)
    {
        $status = $arParam[0];
        $type = $arParam[1];
        $mode = $arParam[2];
        $key = $arParam[3];
        if ($status == TRUE) {
            switch ($type) {
                case "AES":
                    $output = $this->decryptAES($mode, $key, $str);
                    break;
                default:
                    $output = $str;
                    break;
            }
        } else {
            $output = base64_decode($str);
        }
        return $output;
    }

    function encryptAES($key, $str)
    {
        $obAes = new Crypt_AES(CRYPT_AES_MODE_ECB);
        $obAes->setKeyLength(128);
        $obAes->enablePadding();
        if (config('queryservice.encrypt_key')) {
            $key = decrypt($key);
        }
        $obAes->setKey($key);
        $aResult = $obAes->encrypt($str);
        $output = base64_encode($aResult);
        return $output;
    }

    function decryptAES($key, $str)
    {
        global $config;
        $obAes = new Crypt_AES(CRYPT_AES_MODE_ECB);
        $obAes->setKeyLength(128);
        $obAes->enablePadding();
        if (config('queryservice.encrypt_key')) {
            $key = decrypt($key);
        }
        $obAes->setKey($key);
        $aResult = base64_decode($str);
        $output = $obAes->decrypt($aResult);
        return $output;
    }


    function CurlPostRequest($host, $port, $address, $postfields, &$aResp)
    {
        global $app;

        $jsonPostfields = json_encode($postfields);
        Log::channel('request')->info("[" . strftime("%Y%m%d%H%M%S", time()) . "][REQUEST][" . $host . ":" . $port . "]  : " . $address . ' ' . $jsonPostfields);
        // error_log('[' . date('d-m-Y H:i:s') . '][' . $host . ':' . $port . '][REQ] ' . $address . " " . $jsonPostfields . "\n", 3, '/tmp/' . date('Ymd') . '_api_' . $app['name'] . '.log');
        // $error_log_path = 'C:\\laragon\\www\\projek-recis\\log\\' . date('Ymd') . '_mpn-id-billing.log';
        // error_log('[' . date('d-m-Y H:i:s') . '][' . $address . ':' . $port . '][REQ] ' . $out . "\n", 3, $error_log_path);
        $curl = curl_init();

        $curlAddress = 'http://' . $host . ':' . $port . '/' . $address;

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $curlAddress,
            CURLOPT_POSTFIELDS => $jsonPostfields,
            CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($jsonPostfields))
        ));

        $response = curl_exec($curl);

        $responseStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($responseStatusCode == 200) {
            $aResp = $response;

            return TRUE;
        } else {
            $errorMessage = curl_error($curl);
            $httpResponse = array(
                "responseCode" => $responseStatusCode,
                "responseMsg" => $errorMessage
            );
            $aResp = json_encode($httpResponse);

            return FALSE;
        }

        Log::channel('response')->info("[" . strftime("%Y%m%d%H%M%S", time()) . "][RESPONSE][" . $host . ":" . $port . "]  : " . $address . ' ' .   $aResp);
        curl_close($curl);
    }
}
