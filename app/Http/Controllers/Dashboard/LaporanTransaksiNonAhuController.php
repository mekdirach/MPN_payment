<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\Facades\QS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanTransaksiNonAhuController extends Controller
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

        return view('pages.dashboard.TransaksiNonAhu.index', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $laporan = QS::call('MPN.GetKementrianSetting', [
            "a" => ""
        ]);

        $kementrian_value = array();
        foreach ($laporan->getData() as $row) {
            if ($row['MPN_TRX_PNBP'] != '') {
                $kementrian_value[$row['MPN_TRX_PNBP']] = $row['MPN_TRX_NAME'];
            }
        }

        return response()->json([
            'kementrian_value' => $kementrian_value,
        ]);
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
        $NonAHU = $request->input('non_ahu');

        // Menghitung offset berdasarkan halaman saat ini
        $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');

        if (empty($start_date) && empty($end_date)) {
            $laporanTotal = QS::call('MPN.GetNumRowsLaporanNonAHU', [
                "e" => $NonAHU
            ]);
        } else {


            $laporanTotal = QS::call('MPN.GetNumRowsLaporanNonAHUDT', [
                "a" => $start_date . ' 00:00:00',
                "b" => $end_date . ' 23:59:59',
                "e" => $NonAHU
            ]);
        }

        var_dump($laporanTotal);
        if ($laporanTotal->isSuccess()) {

            // Jika hanya terdapat pencarian berdasarkan tanggal
            if (!empty($startDate) && !empty($endDate)) {
                $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');


                $laporan = QS::call('MPN.SelectAllLaporanNonAHUDT', [
                    "a" => $startDate . '00:00:00',
                    "b" =>  $endDate . '23:59:59',
                    "e" => $NonAHU
                ]);
            }
            // Jika tidak ada pencarian tanggal dan kata kunci
            else {
                $laporan = QS::call('MPN.SelectAllLaporanNonAHU', [
                    "e" => $NonAHU
                ]);
            }


            if ($laporan->isSuccess()) {
                $result = $laporan->getData();

                // $total_pages = ceil($totalItems / $rowCount);
                return response()->json([
                    'items' => $result
                ]);
            } else {
                return response()->json(['error' => 'Failed to retrieve data'], 500);
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
        //
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
