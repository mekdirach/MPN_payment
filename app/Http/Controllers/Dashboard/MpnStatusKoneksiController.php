<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\QueryService;
use Illuminate\Http\Request;

class MpnStatusKoneksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mpnstatuskoneksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $aResp = "";
        $fUrl = 'mpnsettlement/check_connection';
        date_default_timezone_set('Asia/Jakarta');
        $postFields = array();
        $postFields['localDatetime'] = date("Y-m-d H:i:s");
        $postFields['terminalLocation'] = "BJBFAST 0001";
        $postFields['paymentCode'] = "100000000000xxx";
        $postFields['accountSource'] = "0001100430360";
        $postFields['channelType'] = "7012";
        $postFields['currency'] = "IDR";
        $postFields['terminalId'] = "02A002";
        $postFields['settlementDate'] = "0822";
        $postFields['transactionId'] = "133902";

        $Json = new QueryService();
        $cekStatus = $Json->CurlPostRequest(config('config.host'), config('config.port'), $fUrl, $postFields, $aResp);
		
        if ($cekStatus) {

            $resCekStatus = json_decode($aResp, TRUE);
            if (isset($resCekStatus['responseCode']) && $resCekStatus['responseCode'] == '0000') {

                $response = [
                    'success', $resCekStatus['responseMessage'],
                ];
            } else {
                $response = [
                    'error', $resCekStatus['responseMessage'],
                ];
            }
            return response()->json($response)->setStatusCode(200);
        } else {
            $response = [
                'error', '[RC 0005] Terjadi kesalahan Connec.',
            ];

            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
