<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tg_biller_mpn_tran_main;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrasaksiNonAhuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        //MPN.GetNumRowsLaporanTransDT

        if ($request->start_date || $request->end_date) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $items = tg_biller_mpn_tran_main::whereBetween('tgb_tm_tran_dt', [$start_date, $end_date])->get();
            // $data = holiday::select('SELECT holiday_date
            // WHERE holiday_date BETWEEN ' . $start_date . 'and' . $end_date);
        } else {
            $items = tg_biller_mpn_tran_main::latest()->get();
        }

        return response()->json(['items' => $items]);
    }
}
