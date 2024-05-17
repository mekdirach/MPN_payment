<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\Facades\QS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanTransaksiController extends Controller
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
        $user = Auth::user();

        return view('pages.dashboard.transaksiahu.index', $user);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $limit = $request->input('row_count');
        $page = $request->input('page');

        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $limit;

        // Query untuk mendapatkan total baris


        if (!empty($start_date) && !empty($end_date)) {
            $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');
            $laporanTotal = QS::call('MPN.GetNumRowsLaporanTransDT', [
                "a" => $start_date . ' 00:00:00',
                "b" => $end_date . ' 23:59:59',
            ]);
        } else {
            $laporanTotal = QS::call('MPN.GetNumRowsLaporanTrans', [
                "a" => "",
            ]);
        }

        if ($laporanTotal->isSuccess()) {
            $resultTotal = $laporanTotal->getData();

            if (isset($resultTotal[0]->NUM_ROWS)) {
                $totalItems = $resultTotal[0]->NUM_ROWS;

                // Menghitung total halaman
                $totalPages = ceil($totalItems / $limit);

                // Menentukan tombol previous/next
                $previousPage = ($page > 1) ? $page - 1 : null;
                $nextPage = ($page < $totalPages) ? $page + 1 : null;

                // Jika hanya terdapat pencarian berdasarkan tanggal
                if (!empty($start_date) && !empty($end_date)) {
                    $laporan = QS::call('MPN.SelectAllLaporanTransDT', [
                        "a" => $start_date . ' 00:00:00',
                        "b" => $end_date . ' 23:59:59',
                        "c" => $offset,
                        "d" => $limit
                    ]);
                } else {
                    $laporan = QS::call('MPN.SelectAllLaporanTrans', [
                        "a" => "",
                        "c" => $offset,
                        "d" => $limit
                    ]);
                }

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
    public function show(Request $request)
    { {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $limit = $request->input('row_count');
            $page = $request->input('page');

            // Menghitung offset berdasarkan halaman saat ini
            $offset = ($page - 1) * $limit;
            // Query untuk mendapatkan total baris
            $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            if (!empty($start_date) && !empty($start_date)) {
                $laporanTotal = QS::call('MPN.GetNumRowsLaporanTransDT', [
                    "a" => $start_date,
                    "b" => $start_date,
                ]);
            } else {
                $laporanTotal = QS::call('MPN.GetNumRowsLaporanTrans', [
                    "a" => "",
                ]);
            }

            if ($laporanTotal->isSuccess()) {
                $resultTotal = $laporanTotal->getData();

                if (isset($resultTotal[0]->NUM_ROWS)) {
                    $totalItems = $resultTotal[0]->NUM_ROWS;

                    // Menghitung total halaman
                    $totalPages = ceil($totalItems / $limit);

                    // Menentukan tombol previous/next
                    $previousPage = ($page > 1) ? $page - 1 : null;
                    $nextPage = ($page < $totalPages) ? $page + 1 : null;
                    // Jika jumlah data kurang dari rowCount, maka prevPage dan nextPage akan null
                    if ($totalItems <= $limit) {
                        $previousPage = null;
                        $nextPage = null;
                    }

                    // Jika hanya terdapat pencarian berdasarkan tanggal
                    if (!empty($start_date) && !empty($start_date)) {

                        $laporan = QS::call('MPN.SelectAllLaporanTransDT', [
                            "a" => $start_date . ' 00:00:00',
                            "b" => $end_date . ' 23:59:59',
                            "c" => $offset,
                            "d" => $limit
                        ]);
                    }
                    /*if (empty($startDate['startdt']) && empty($endDate['enddt'])) {
        
                            $laporan = QS::call('MPN.SelectAllLaporanTrans', [
                                "a" => "",
                                "c" => $offset,
                                "d" => $limit,
                            ]);
                        } else {
                            $startDate['startdt'] = Carbon::createFromFormat('m/d/Y', $startDate['startdt'])->format('Y-m-d');
                            $endDate['enddt'] = Carbon::createFromFormat('m/d/Y', $endDate['enddt'])->format('Y-m-d');
        
                            $laporan = QS::call('MPN.SelectAllLaporanTransDT', [
                                "a" => $startDate['startdt'],
                                "b" =>  $endDate['enddt'],
                                "c" => $offset,
                                "d" => $limit,
                            ]);
                        }*/


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
    }
}
