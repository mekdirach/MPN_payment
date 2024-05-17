<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\tg_biller_mpn_tran_main;
use App\Services\QueryService\Facades\QS;
use App\Services\QueryService\QueryService;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Exports\LogTransExport;
use Str;

class TransaksiController extends Controller
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
    public function index()
    {
        Auth::user();
        return view('pages.dashboard.Transaksi.index');
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $rowCount = $request->input('row_count');
        $ntpn = $request->input('nt_pn');
        $status = $request->input('status_filter');
        $keywords = $request->input('keywords');
        $page = $request->input('page');

        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $rowCount;

        switch ($ntpn) {
            case '2':
                $sqlNTPN = "=";
                break;
            case '1':
                $sqlNTPN = "<>";
                break;
            default:
                $sqlNTPN = "=";
        }
        // Mengonversi kata kunci menjadi huruf kecil
        $keywordsLower = strtolower($keywords);

        // Mengganti spasi dengan "%20" pada kata kunci
        $keywordsLower = str_replace(' ', '%20', $keywordsLower);

        // Inisialisasi array filter
        $filters = [];

        // Jika kata kunci tidak kosong, tambahkan filter ke array
        if (!empty($keywordsLower)) {
            $filters[] = $keywordsLower;
        }

        if (empty($startDate) && empty($endDate)) {
            $keywords = strtoupper($keywords);
            $laporanTotal = QS::call('MPN.GetNumRowsLogTrans', [
                "a" => $keywords,
                "f" => $sqlNTPN,
                "g" => $status
            ]);
        } elseif (!empty($startDate) && !empty($endDate) && empty($keywords)) {
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Ymd');
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Ymd');
            $laporanTotal = QS::call('MPN.GetNumRowsLogTransDT', [
                "a" => "",
                "b" => $startDate . '000000',
                "c" => $endDate . '235959',
                "f" => $sqlNTPN,
                "g" => $status
            ]);
        } else {
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Ymd');
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Ymd');
            $laporanTotal = QS::call('MPN.GetNumRowsLogTransDT', [
                "a" => $keywords,
                "b" => $startDate . '000000',
                "c" => $endDate . '235959',
                "f" => $sqlNTPN,
                "g" => $status
            ]);
        }

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
                // Jika hanya terdapat pencarian berdasarkan tanggal
                if (!empty($startDate) && !empty($endDate) && empty($keywords)) {

                    $laporan = QS::call('MPN.SelectAllLogTransDT', [
                        "a" => "",
                        "b" => $startDate . '000000',
                        "c" => $endDate . '235959',
                        "d" => $offset,
                        "e" => $rowCount,
                        "f" => $sqlNTPN,
                        "g" => $status
                    ]);
                }
                // Jika terdapat pencarian berdasarkan tanggal dan kata kunci
                elseif (!empty($startDate) && !empty($endDate) && !empty($keywords)) {
                    //$keywordsLower = Str::lower($keywords);
                    $laporan = QS::call('MPN.SelectAllLogTransDT', [
                        "a" => $keywords,
                        "b" => $startDate . ' 000000',
                        "c" => $endDate . ' 235959',
                        "d" => $offset,
                        "e" => $rowCount,
                        "f" => $sqlNTPN,
                        "g" => $status
                    ]);
                }
                // Jika tidak ada pencarian tanggal dan kata kunci
                else {
                    $laporan = QS::call('MPN.SelectAllLogTrans', [
                        "a" => $keywords,
                        "d" => $offset,
                        "e" => $rowCount,
                        "f" => $sqlNTPN,
                        "g" => $status
                    ]);
                }
                if ($laporan->isSuccess()) {
                    $result = $laporan->getData();

                    // $total_pages = ceil($totalItems / $rowCount);
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
    public function show(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $rowCount = $request->input('row_count');
        $ntpn = $request->input('nt_pn');
        $keywords = $request->input('keywords');
        $page = $request->input('page');

        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $rowCount;

        switch ($ntpn) {
            case '2':
                $sqlNTPN = "IS";
                break;
            case '1':
                $sqlNTPN = "IS NOT";
                break;
            default:
                $sqlNTPN = "IS";
        }

        // Prepare the query parameters for QueryService
        $queryParams = [
            "d" => $offset,
            "e" => $rowCount,
            "f" => $sqlNTPN
        ];

        // Jika terdapat pencarian berdasarkan tanggal dan kata kunci
        if (empty($startDate) && empty($endDate)) {
            $queryParams["a"] = $keywords;
            $laporan = QS::call('MPN.SelectAllLogTrans', $queryParams);
        } elseif (empty($keywords)) {
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');
            $queryParams["a"] = null;
            $queryParams["b"] = $startDate . ' 00:00:00';
            $queryParams["c"] = $endDate . ' 23:59:59';
            $laporan = QS::call('MPN.SelectAllLogTransDT', $queryParams);
        } else {
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');
            $queryParams["a"] = $keywords;
            $queryParams["b"] = $startDate . ' 00:00:00';
            $queryParams["c"] = $endDate . ' 23:59:59';
            $laporan = QS::call('MPN.SelectAllLogTransDT', $queryParams);
        }

        if ($laporan->isSuccess()) {
            $result = $laporan->getData();
            return response()->json([
                'items' => $result
            ]);
        } else {
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $ntpn = $request->input('TM_NTPN');
        $TM_ID = $request->input('TM_ID');
        $laporan = QS::call('MPN.EditNTPN', [
            "a" => $TM_ID,
            "b" => $ntpn,
        ]);
        if ($laporan->isSuccess()) {
            $result = $laporan->getData();
            return response()->json(['mmesange' => $result], 200);
        } else {
            return response()->json(['error' => 'Gagal memperbarui data'], 500);
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
        $ntpn = $request->input('TM_NTPN');

        $aReq = array(
            'MT' => '2200',
            'PC' => '15400',
            'ST' => date('His'),
            'DT' => date('YmdHis'),
            'MPI' => array('ID' => $id, 'NTPN' => $ntpn)
        );

        $queryService = new QueryService();
        $bOK = $queryService->JsonExec($aRes, $aReq);

        if ($bOK) {

            if ($aRes->RC === '0000') {
                $respone =  [
                    'message' => 'success'
                ];
            } else {
                $respone =  [
                    'eror' => $aRes->RCMSG . ' (Kode: ' . $aRes->RC . ')',
                ];
            }
        } else {
            $respone =  [
                'eror' => 'Tidak ada respon dari sistem.',
            ];
        }

        return response()->json([
            'data' => $respone
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportToExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $ntpn = $request->input('nt_pn');
        $status = $request->input('status_filter');
        $keywords = $request->input('keywords');

        // Fetch data using QueryService - Adjust this query based on your application
        $laporan = QS::call('YourQueryServiceMethod', [
            "start_date" => $startDate,
            "end_date" => $endDate,
            "nt_pn" => $ntpn,
            "status_filter" => $status,
            "keywords" => $keywords,
        ]);

        if ($laporan->isSuccess()) {
            $result = $laporan->getData();

            // Use the LogTransExport class to handle the export logic
            return Excel::download(new LogTransExport($result), 'log_trans.xlsx');
        } else {
            return response()->json(['error' => 'Failed to retrieve data for export'], 500);
        }
    }

    public function destroy($id)
    {
        return abort(404);
    }
}
