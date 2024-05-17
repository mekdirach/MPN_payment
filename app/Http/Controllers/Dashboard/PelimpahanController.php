<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\inc\ctr\centralJson as ctr;
use App\Services\QueryService\Facades\QS;
use App\Services\QueryService\QueryService;
use App\Traits\Connection\ConnectionTrait;
use App\Traits\Connection\Services_JSON;
use App\Traits\template\templateForm;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PHPUnit\Util\Json;
use stdClass;

class PelimpahanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user();
        return view('pages.dashboard.pelimpahan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }
    private $DSJson = NULL;
    private $DSLink = NULL;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mata_uang = $request->input('mata_uang');
        date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan zona waktu yang diharapkan
        $datetime = date('Ymd');
        $JSONMPI = new Services_JSON(SERVICES_JSON_SUPPRESS_ERRORS);
        $MPI = array('CUR' => $mata_uang);
        $JMPI = $JSONMPI->encode($MPI);
        // $batchIdExpiration = Config::get('cookies.batchid_');
        $aReq = array(
            'MT' => '2200',
            'PC' => '15000',
            'ST' => '01000',
            'DT' => $datetime,
            'MPI' => $JMPI //json objek
        );
        $queryService = new QueryService();
        $bOK = $queryService->JsonExec($aRes, $aReq);
        if ($bOK) {
            if ($aRes->RC == '0000') {
                if (!isset($aRes->MPO->DTLP) || $aRes->MPO->DTLP === NULL) {
                    $expireTimeInMinutes = 2 * 24 * 60; // 2 hari x 24 jam x 60 menit
                    $cookie = cookie('batchid', $aRes->MPO->BATCHID, $expireTimeInMinutes);
                    return response()->json(['message' => $aRes->RC . '  Pelimpahan terakhir dengan Batch ID ' . $aRes->MPO->BATCHID . ' belum diberikan nomor sakti. <br> Silahkan ke menu Pengisian Nomor Sakti untuk mengisi nomor sakti dengan Batch ID ' . $aRes->MPO->BATCHID])->cookie($cookie);
                } else {
                    $expireTimeInMinutes = 2 * 24 * 60; // 2 hari x 24 jam x 60 menit
                    $cookie = cookie('batchid', $aRes->MPO->BATCHID, $expireTimeInMinutes);

                    //  var_dump($aRes);
                    return response()->json([
                        'Status' => 'Pelimpahan Berhasil',
                        'Tanggal_Pelimpahan' => date('d-m-Y H:i:s', strtotime('20' . $aRes->MPO->DTLP)),
                        'Mata_Uang' => $aRes->MPO->CUR,
                        'Batch_ID' => $aRes->MPO->BATCHID,
                        'Total_Transaksi' => number_format($aRes->MPO->TOTALSUM),
                        'Jumlah_Transaksi' => $aRes->MPO->TOTALROW
                    ])->cookie($cookie);
                }

                //setcookie('batchid', $aRes->MPO->BATCHID, time() + $config['sess_expiration']);
            } else {
                return response()->json(['error' => '[' . $aRes->RC . '] ' . $aRes->RCMSG]);
            }
        }
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
