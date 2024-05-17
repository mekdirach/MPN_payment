<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\Facades\QS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceFlagingController extends Controller
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

        return view('pages.dashboard.force.index', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aReqs = ['a' => '1'];
        $laporan = QS::call('MPN.getFailedPaymentRecordsAll', ['a' => $aReqs]);


        if ($laporan->isSuccess()) {
            $result = $laporan->getData()->toArray();
            $allId = implode(',', array_column($result, 'BILLID'));

            var_dump("hihihi", $result);
            return response()->json([
                'data' => $result,
            ], 200);
        } else {
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keywords = array('a' => '1');
        $limit = $request->input('row_count');
        $page = $request->input('page');

        $offset = ($page - 1) * $limit;

        $laporanTotal = QS::call('MPN.getFailedPaymentRecordsNumRows', [
            "a" =>  $keywords,
        ]);

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

                $laporan = QS::call('MPN.getFailedPaymentRecords', [
                    "a" => $keywords,
                    "c" => $offset,
                    "d" => $limit
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
            return response()->json(['error' => 'Empty Data Items'], 500);
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
        if ($request->has('bill_id')) {
            $billIds = $request->input('bill_id');

            if (is_array($billIds)) {
                $dataId = $billIds;
            } else {
                $dataId = explode(",", $billIds);
            }

            $xc = 0;
            $result = []; // Inisialisasi array untuk hasil

            foreach ($dataId as $idProc) {
                $billId =  $idProc;
                $bOk = QS::call('MPN.updateFailedPaymentRecords', [
                    "a" => $billId,
                ]);

                if ($bOk->isSuccess()) {
                    $result[] = $bOk->getData()[0]->EFFECTED_ROWS;

                    $xc++;
                }
            }

            return response()->json([
                'message' => '(' . $xc . ') Data berhasil diproses',
                'data' => $result,
            ], 200);
        } else {
            return response()->json([
                'error' => 'Tidak ada data bill_id yang diterima',
            ], 400);
        }
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
