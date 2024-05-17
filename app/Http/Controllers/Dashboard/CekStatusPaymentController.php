<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\tg_biller_mpn_tran_main;
use App\Services\QueryService\Facades\QS;
use App\Services\QueryService\QueryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CekStatusPaymentController extends Controller
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
        $data  = Auth::user();
        return view('pages.dashboard.cekstatus.index')->with('data', $data);
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
		

        $laporanTotal = QS::call('MPN.GetNumRowsCekStatusPayment', [
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
				

                $laporan = QS::call('MPN.SelectCekStatusPayment', [
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
        // $aResp = "";

        $fUrl = 'mpnsettlement/cek_status';
        $postFields = array();
        $postFields['paymentCode'] = $id;
        $Json = new QueryService();

        $cekStatus = $Json->CurlPostRequest(config('config.host'), config('config.port'), $fUrl, $postFields, $aResp);
        if ($cekStatus) {
            $resCekStatus = json_decode($aResp, TRUE);

            if (isset($resCekStatus['responseCode']) && $resCekStatus['responseCode'] == '00') {

                $response = [
                    'success', $resCekStatus,
                ];
            } else {
                $response = [
                    'error', $resCekStatus,
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

			$fUrl = 'mpnsettlement/cek_status';
			$Json = new QueryService();
			$responses = [];
			
			foreach ($dataId as $billId) {
				$postFields = ['paymentCode' => $billId];

				$start = microtime(true);

				$cekStatus = $Json->CurlPostRequest(config('config.host'), config('config.port'), $fUrl, $postFields, $aResp);

				$executionTime = microtime(true) - $start;
				Log::info("Execution time for paymentCode $billId: $executionTime seconds");
				//var_dump($cekStatus, $aResp);
				if ($cekStatus) {
					$resCekStatus = json_decode($aResp, TRUE);

					if (isset($resCekStatus['responseCode']) && $resCekStatus['responseCode'] == '00') {

						$response = [
							'success', $resCekStatus,
						];
					} else {
						$response = [
							'error', $resCekStatus,
						];
					}
					
				} else {
					$response = [
						'error', '[RC 0005] Terjadi kesalahan saat cek status payment.',
					];

					return response()->json($response);
				}
			}
			return response()->json($response)->setStatusCode(200);
		}

}
