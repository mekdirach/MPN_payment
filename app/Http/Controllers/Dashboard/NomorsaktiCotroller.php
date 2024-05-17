<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\QueryService\Facades\QS;
use App\ctr\central\central;
use App\Services\QueryService\QueryService;
use central as GlobalCentral;
use centralJson;
use centralMPN;
use ctrJson;
use App\template\templateForm;
use App\Traits\Connection\Services_JSON;
use Illuminate\Support\Facades\DB;
use templateForm as GlobalTemplateForm;

class NomorsaktiCotroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $batchId = $request->cookie('batchid');

        return view('pages.dashboard.nomorsakti.index', $user)->with('batchId', $batchId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkNomorSakti(Request $request)
    {
        $nomorSakti = $request->input('nomorSakti');
        $record = DB::table('tg_biller_mpn_tran_main')->where('tgb_tm_no_sakti', $nomorSakti)->first();

        if ($record) {
            return response()->json(['success' => false, 'message' => 'Nomor Sakti sudah ada.']);
        }

        return response()->json(['success' => true]); // Nomor Sakti valid
    }

    public function create()
    {

        // return response()->json($responseData);

        /* $bOK = Json->JsonExec($aRes, $aReq);
            if ($aRes->RC == '000') {
                # code...
            }*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $batchId = $request->input('batchId');
        $nomorSakti = $request->input('nomorSakti');
        date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan zona waktu yang diharapkan
        $datetime = date('Ymd');
        $JSONMPI = new Services_JSON(SERVICES_JSON_SUPPRESS_ERRORS);
        $NOSK = array(
            'BATCHID' => $batchId,
            'NOSAKTI' => $nomorSakti
        );
        $JNOSK = $JSONMPI->encode($NOSK);
        $aReq = array(
            'MT' => '2100',
            'PC' => '15100',
            'ST' => '01000',
            'DT' => $datetime,
            'MPI' => $JNOSK
        );
        $queryService = new QueryService();

        $bOK = $queryService->JsonExec($aRes, $aReq);
        if ($bOK) {
            if ($aRes->RC == '0000') {
                $responseData = [
                    'Tgl Pelimpahan' => date('d-m-Y H:i:s', strtotime('20' . $aRes->MPO->DTLP)),
                    'Batch Id' => $aRes->MPO->BATCHID,
                    'Mata Uang' => $aRes->MPO->CUR,
                    'Nomor Sakti' => $aRes->MPO->NOSAKTI,
                    'Nomor Rekening' => $aRes->MPO->NOREK,
                    'Total Pembayaran' => number_format($aRes->MPO->TOTALSUM),
                    'Jumlah Transaksi' => $aRes->MPO->TOTALROW
                ];
                $response = [
                    'success' => true,
                    'data' => $responseData,
                    'foot' => [
                        [
                            'type' => 'hidden',
                            'name' => 'batchId',
                            'value' => $aRes->MPO->BATCHID
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'noSakti',
                            'value' => $aRes->MPO->NOSAKTI
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'dtlp',
                            'value' => $aRes->MPO->DTLP
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'cur',
                            'value' =>  $aRes->MPO->CUR
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'noRek',
                            'value' => $aRes->MPO->NOREK
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'totalSum',
                            'value' => $aRes->MPO->TOTALSUM
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'totalRow',
                            'value' => $aRes->MPO->TOTALROW
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'refnum',
                            'value' => $aRes->REFNUM
                        ],
                        [
                            'type' => 'submit',
                            'name' => 'submit_lanjutkan',
                            'value' => 'Lanjutkan',
                            'onClick' => 'return pre_submit()'
                        ]
                    ]
                ];
                return response()->json($response,  200);
            } else {
                return response()->json(['message' => 'Tidak ada response dari sistem.'], 400);
            }
        } else {
            $response = array(
                'success' => false,
                'message' => '[' . $aRes->RC . '] ' . $aRes->RCMSG
            );
            return response()->json($response, 400);
        }
    }

    public function pre_submit(Request $request)
    {
        $batchId = $request->input('batchId');
        $noSakti = $request->input('nomorSakti');
        $dtlp = $request->input('batchId');
        $cur = $request->input('nomorSakti');
        $totalSum = $request->input('batchId');
        $totalRow = $request->input('nomorSakti');
        $noRek = $request->input('batchId');
        $refnum = $request->input('nomorSakti');
        $aReq = array(
            'MT' => '2200',
            'PC' => '15200',
            'ST' => '01000',
            'DT' => date('YmdHis'),
            'MPI' => array(
                'BATCHID' => $batchId,
                'NOSAKTI' => $noSakti
            ),
            'MPO' => array(
                'BATCHID' => $batchId,
                'NOSAKTI' => $noSakti,
                'DTLP' => $dtlp,
                'CUR' => $cur,
                'TOTALSUM' => $totalSum,
                'TOTALROW' => $totalRow,
                'NOREK' => $noRek
            ),
            'REFNUM' => $refnum
        );

        $queryService = new QueryService();

        $bOK = $queryService->JsonExec($aRes, $aReq);

        if ($bOK) {
            if ($aRes->RC == '0000') {
                $response = [
                    'success' => true,
                    'message' => 'Pengisian Nomor Sakti Berhasil'
                ];
                unset($_COOKIE['batchid']);
            } else {
                $response = [
                    'success' => false,
                    'message' => '[' . $aRes->RC . '] ' . $aRes->RCMSG
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Tidak ada respon dari sistem.'
            ];
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
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
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }
}
