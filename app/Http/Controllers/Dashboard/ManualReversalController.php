<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\Facades\CurlPost;
use App\Services\QueryService\Facades\QS;
use App\Traits\Connection\ConnectionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\QueryService\CurlPostRequest;
use App\Services\QueryService\QueryService;
use Illuminate\Support\Facades\Log;

class ManualReversalController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * $user = auth()->user()->id;

     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('pages.dashboard.manualreveral.index', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rowCount = $request->input('row_count');
        $keywords = strtoupper($request->input('keywords'));
        $page = $request->input('page');


        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $rowCount;
        // Query untuk mendapatkan total baris

        $laporanTotal = QS::call('MPN.GetNumRowsTransReversal', [
            "a" => $keywords,
            "f" => "",
        ]);

        if ($laporanTotal->isSuccess()) {
            $resultTotal = $laporanTotal->getData();

            if (isset($resultTotal[0]->NUM_ROWS)) {
                $totalItems = $resultTotal[0]->NUM_ROWS;

                // Menghitung total halaman
                $totalPages = ceil($totalItems / $rowCount);

                // Menentukan tombol previous/next
                $previousPage = ($page > 1) ? $page - 1 : null;
                $nextPage = ($page < $totalPages) ? $page + 1 : null;

                // Jika jumlah data kurang dari rowCount, maka prevPage dan nextPage akan null
                if ($totalItems <= $rowCount) {
                    $previousPage = null;
                    $nextPage = null;
                }


                $laporan = QS::call('MPN.SelectTransReversal', [
                    "a" => $keywords,
                    "d" => $offset,
                    "e" => $rowCount,
                    "f" => "",
                ]);
                if ($laporan->isSuccess()) {
                    $result = $laporan->getData();


                    return response()->json([
                        'items' => $result,
                        'currentPage' => $page,
                        'lastPage' => $totalPages,
                        'previousPage' => $previousPage,
                        'nextPage' => $nextPage,
                    ]);
                } else {
                    return response()->json(['error' => 'Failed to retrieve data'], 500);
                }
            } else {
                return response()->json(['error' => 'Invalid data format'], 500);
            }
        } else {
            // Penanganan kesalahan jika query total baris gagal
            return response()->json(['error' => 'Failed to retrieve total items'], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fUrl = 'mpnsettlement/reversal';
        $postFields = array();
        $postFields['paymentCode'] = $id;
        $Json = new QueryService();
        $cekStatus = $Json->CurlPostRequest(config('config.host'), config('config.port'), $fUrl, $postFields, $aResp);
        //var_dump( $cekStatus, $aResp);

        if ($cekStatus) {
            $resCekStatus = json_decode($aResp, TRUE);

            if (isset($resCekStatus['RESPONSE_CODE']) && $resCekStatus['RESPONSE_CODE'] == '0000') {

                $response = [
                    'success', $resCekStatus['RESPONSE_MESSAGE'],
                ];
            } else {
                $response = [
                    'error', $resCekStatus['responseMessage'],
                ];
            }
            return response()->json($response)->setStatusCode(200);
        } else {
            $response = [
                'error', '[RC 0005] Terjadi kesalahan saat cek status payment.',
            ];

            return response()->json($response);
        }
    }

    public function action(Request $request)
    {
        $billIds = $request->input('bill_id');
        $dataId = is_array($billIds) ? $billIds : explode(",", $billIds);

        $fUrl = 'mpnsettlement/reversal';
        $Json = new QueryService();
        $response = [];
        $errorCount = 0;
        $successCount = 0;

        foreach ($dataId as $billId) {
            $postFields = ['paymentCode' => $billId];

            $cekStatus = $Json->CurlPostRequest(config('config.host'), config('config.port'), $fUrl, $postFields, $aResp);

            if ($cekStatus) {
                $resCekStatus = json_decode($aResp, TRUE);

                if (isset($resCekStatus['RESPONSE_CODE']) && $resCekStatus['RESPONSE_CODE'] == '0000') {
                    $response[] = [
                        'success', $resCekStatus['RESPONSE_MESSAGE'],
                        'paymentCode' => $billId,
                    ];
                    $successCount++;
                } else {
                    $response[] = [
                        'error', $resCekStatus['responseMessage'],
                        'data' => $resCekStatus,
                        'paymentCode' => $billId,
                    ];
                    $errorCount++;
                }
            } else {
                $response = [
                    'error', '[RC 0005] Terjadi kesalahan saat cek status payment.',
                ];
                return response()->json($response);
            }
        }

        // Ambil satu data respons berdasarkan yang terbanyak
        $responseData = [];
        if ($successCount > $errorCount) {
            $responseData = [
                'successCount' => $successCount,
                'errorCount' => $errorCount,
                'responses' => array_filter($response, function ($item) {
                    return $item[0] === 'success';
                }),
            ];
        } elseif ($errorCount > $successCount) {
            $responseData = [
                'errorCount' => $errorCount,
                'successCount' => $successCount,
                'responses' => array_filter($response, function ($item) {
                    return $item[0] === 'error';
                }),
            ];
        }

        return response()->json($responseData)->setStatusCode(200);
    }


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
