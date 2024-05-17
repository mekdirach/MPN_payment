<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tg_biller_mpn_tran_main;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $items = tg_biller_mpn_tran_main::all();
        return response()->json($items);
    }

    public function search(Request $request)
    {

        /*
                    $param1Start = $request->input('param1_start');
                    $param1End = $request->input('param1_end');


                    if ($request->start_date || $request->end_date ||  $keywords = $request->input('keywords')) {
                        $param1Start  = Carbon::parse($request->start_date)->format('Y-m-d');
                        $param1End = Carbon::parse($request->end_date)->format('Y-m-d');
                        $items = tg_biller_mpn_tran_main::where(function ($query) use ($keywords,  $param1Start, $param1End) {
                            foreach ($keywords as $keyword) {
                                $query->orWhere(function ($subQuery) use ($keyword, $param1Start,  $param1End) {
                                    $subQuery->whereBetween('tgb_tm_tran_dt', [$param1Start, $param1End])
                                        ->orWhereRaw('LOWER(tgb_tm_bill_id) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_ntb) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_ntpn) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_refnum) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_npwp) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_nama_wajib_pajak) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_nama_wajib_bayar) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_amount) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_batch_id) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_nomor_sk) LIKE ?', ['%' . $keyword . '%'])
                                        ->orWhere('LOWER(tgb_tm_msg_rc) LIKE ?', ['%' . $keyword . '%']);
                                });
                            }
                        })->get();
                    } else {
                        $items = tg_biller_mpn_tran_main::latest()->get();
                    }
                    */

        $keywords = $request->input('keywords');
        $items = tg_biller_mpn_tran_main::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function ($subQuery) use ($keyword) {
                    $subQuery->whereRaw("LOWER(tgb_tm_bill_id) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_ntb) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_ntpn) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_refnum) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_npwp) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_nama_wajib_pajak) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_nama_wajib_bayar) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_amount) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_batch_id) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_nomor_sk) LIKE ?", ['%' . strtolower($keyword) . '%'])
                        ->orWhereRaw("LOWER(tgb_tm_msg_rc) LIKE ?", ['%' . strtolower($keyword) . '%']);
                });
            }
        })->get();

        if ($items) {
            return response()->json($items);
        } else {
            return response()->json(null);
        }
    }
}
