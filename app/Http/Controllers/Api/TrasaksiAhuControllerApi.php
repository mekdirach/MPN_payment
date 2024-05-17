<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tg_biller_mpn_tran_main;
use App\Services\QueryService\Facades\QS;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrasaksiAhuControllerApi extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $limit = $request->input('row_count');
        $page = $request->input('page');

        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $limit;

        if ($start_date && $end_date) {
            $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');

            $response = QS::call('MPN.SelectAllLaporanTransDT', [
                "a" => $start_date,
                "b" => $end_date,
                "c" => $offset,
                "d" => $limit
            ]);

            if ($response->isSuccess()) {
                $result = $response->getData();
                return response()->json([
                    'items' => $result
                ]);
            } else {
                return response()->json(['error' => 'Failed to retrieve data'], 500);
            }
        }
    }

    public function store(Request $request)
    {
    }
    public function cari(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $limit = $request->input('row_count');
        $get_total_pages = $request->input('get_total_pages');

        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
            $items = tg_biller_mpn_tran_main::whereBetween('tgb_tm_tran_dt', [$start_date, $end_date])
                ->take($limit)
                ->get();
        } else {
            $items = tg_biller_mpn_tran_main::latest()
                ->take($limit)
                ->get();
        }

        if ($get_total_pages) {
            $total_pages = ceil(tg_biller_mpn_tran_main::count() / $limit);
            return response()->json(['total_pages' => $total_pages]);
        }

        return response()->json(['items' => $items]);

        //coba
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $limit = $request->input('row_count');
        $page = $request->input('page');

        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $limit;

        if ($start_date && $end_date) {
            $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');

            $response = QS::call('MPN.SelectAllHolidayDT', [
                "a" => $start_date,
                "b" => $end_date,
                "c" => $offset,
                "d" => $limit
            ]);

            if ($response->isSuccess()) {
                $result = $response->getData();
                return response()->json([
                    'items' => $result
                ]);
            } else {
                return response()->json(['error' => 'Failed to retrieve data'], 500);
            }
        }


        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $limit = $request->input('row_count');
        $page = $request->input('page');

        // Menghitung offset berdasarkan halaman saat ini
        $offset = ($page - 1) * $limit;

        // Query database berdasarkan parameter yang diberikan
        $query = tg_biller_mpn_tran_main::query();

        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
            $query->whereBetween('tgb_tm_tran_dt', [$start_date, $end_date]);
        }

        $total_pages = ceil($query->count() / $limit);

        $items = $query->skip($offset)->take($limit)->get();

        return response()->json([
            'items' => $items,
            'currentPage' => $page,
            'lastPage' => $total_pages
        ]);



        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $limit = $request->input('row_count');
        $currentPage = $request->input('page', 1);
        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            $items = tg_biller_mpn_tran_main::whereBetween('tgb_tm_tran_dt', [$start_date, $end_date])
                ->paginate($limit);
        } else {
            $items = tg_biller_mpn_tran_main::latest()
                ->paginate($limit);
        }

        return response()->json([
            'items' => $items->items(), // Data yang relevan untuk ditampilkan
            'currentPage' => $items->currentPage(), // Halaman saat ini
            'lastPage' => $items->lastPage(), // Jumlah total halaman
        ]);

        $result = QS::SqlExec('MPN.SearchData', ['keyword' => $request]);
    }
}
