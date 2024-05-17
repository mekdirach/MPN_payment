<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\holidays;
use App\Services\QueryService\Facades\QS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\QueryService\QueryService;

class HolidayController extends Controller
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
        // $data = holiday::latest()->get();
        return view('pages.dashboard.holiday.index',  $user);
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

    public function input(Request $request)
    {
        $input = new holidays();
        $input->holiday_date = $request->holiday_date;
        $input->holiday_desc = $request->holiday_desc;
        $input->created_by = 3;
        $input->updated_by = 3;
        $input->save();


        return redirect()->route('member.holiday.index');
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
            $laporanTotal = QS::call('MPN.GetNumRowsHolidayDT', [
                "a" => $start_date . ' 00:00:00',
                "b" => $end_date . ' 23:59:59',
            ]);
        } else {
            $laporanTotal = QS::call('MPN.GetNumRowsHoliday', [
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
                    $laporan = QS::call('MPN.SelectAllHolidayDT', [
                        "a" => $start_date . ' 00:00:00',
                        "b" => $end_date . ' 23:59:59',
                        "c" => $offset,
                        "d" => $limit
                    ]);
                } else {
                    $laporan = QS::call('MPN.SelectAllHoliday', [
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
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
        $date = $request->input('tanggal');
        $f_date = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd');
        $laporan = QS::call('MPN.editHoliday', [
            "a" => $id,
            "b" => $f_date,
        ]);
        if ($laporan->isSuccess()) {
            $result = $laporan->getData();


            return response()->json([$result], 200);
        } else {
            return response()->json(['error' => 'Gagal memperbarui data'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = QS::call('MPN.deleteHoliday', [
            "a" => $id
        ]);
        if ($response->isSuccess()) {
            return response()->json(['message' => 'Data berhasil dihapus', $response], 200);
        } else {
            return response()->json(['error' => 'Gagal menghapus data'], 500);
        }
    }
}
